<?php

namespace App\Services\Sweepbright;

use App\Contracts\PropertyRepository;
use App\Models\SweepbrightEstate;
use App\Support\Imports\PropertyData;
use App\Support\Imports\PropertyListItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

/**
 * Source de biens lisant la base SweepBright partagée alimentée par agiprint
 * (même approche que qr-switch : App\Models\SweepbrightEstate sur la connexion
 * "agiprint"). Les champs riches (surface, pièces, DPE/GES) viennent du JSON `data`.
 */
class AgiprintEstateRepository implements PropertyRepository
{
    public function find(string $estateId): ?PropertyData
    {
        $estate = $this->query($estateId);

        return $estate ? $this->map($estate) : null;
    }

    public function estatesForOffice(string $officeId, int $limit = 30): Collection
    {
        return SweepbrightEstate::query()
            ->where('office_id', $officeId)
            ->whereIn('market_status', ['sale', 'let'])
            ->orderByDesc('updated_at')
            ->get()
            ->unique('estate_id')
            ->take($limit)
            ->map(fn (SweepbrightEstate $e): PropertyListItem => new PropertyListItem(
                id: $e->estate_id,
                ville: (string) $e->city,
                typeBien: $this->mapType($e->type),
                prix: is_numeric($e->price) ? (int) $e->price : null,
                reference: $e->reference,
                statut: $this->mapStatut((string) $e->market_status),
                thumbnailUrl: $this->thumbnail($e),
            ))
            ->values();
    }

    private function query(string $ref): ?SweepbrightEstate
    {
        $ref = trim($ref);

        $builder = is_numeric($ref)
            ? SweepbrightEstate::query()->where('id', $ref)
            : SweepbrightEstate::query()->where('estate_id', $ref);

        return $builder->orderByDesc('updated_at')->first();
    }

    private function map(SweepbrightEstate $estate): PropertyData
    {
        $data = $estate->data ?? [];
        $photos = $this->photos($estate);
        $rooms = (int) data_get($data, 'living_rooms', 0) + (int) data_get($data, 'bedrooms', 0);
        $surface = data_get($data, 'sizes.liveable_area.size');
        $epc = data_get($data, 'legal.energy.epc_value');
        $co2 = data_get($data, 'legal.energy.co2_emissions');

        return new PropertyData(
            ville: (string) ($estate->city ?? data_get($data, 'location.city', '')),
            typeBien: $this->mapType($estate->type ?? (string) data_get($data, 'type')),
            pieces: $rooms > 0 ? $rooms.' pièce'.($rooms > 1 ? 's' : '') : '',
            surface: is_numeric($surface) ? (int) round((float) $surface) : null,
            prix: is_numeric($estate->price) ? (int) $estate->price : (is_numeric(data_get($data, 'price.amount')) ? (int) round((float) data_get($data, 'price.amount')) : null),
            dpeClasse: $this->normalizeClass(data_get($data, 'legal.energy.dpe')),
            dpeValeur: is_numeric($epc) ? (int) round((float) $epc) : null,
            gesClasse: $this->normalizeClass(data_get($data, 'legal.energy.greenhouse_emissions')),
            gesValeur: is_numeric($co2) ? (int) round((float) $co2) : null,
            accroche: (string) (data_get($estate->title, 'fr') ?? data_get($data, 'description_title.fr') ?? ''),
            description: Str::of((string) (data_get($estate->description, 'fr') ?? data_get($data, 'description.fr') ?? ''))->trim()->toString(),
            statut: $this->mapStatut((string) $estate->market_status),
            photoUrl: $photos[0] ?? null,
            reference: $estate->reference ?? data_get($data, 'mandate.number'),
            negotiatorEmail: $estate->email ?? data_get($data, 'negotiator.email'),
            photos: $photos,
            propertyUrl: 'https://www.orpi.com/estate/'.$estate->estate_id,
        );
    }

    /**
     * URL des photos numérotées du bien sur le disque "estates" (bucket agicom),
     * triées (1.jpg, 2.jpg, …), thumbnail.jpg exclue.
     *
     * @return array<int, string>
     */
    private function photos(SweepbrightEstate $estate): array
    {
        try {
            return collect(Storage::disk('estates')->files((string) $estate->id))
                ->filter(fn (string $path): bool => (bool) preg_match('#/\d+\.jpg$#', $path))
                ->sortBy(fn (string $path): int => (int) pathinfo($path, PATHINFO_FILENAME))
                ->map(fn (string $path): string => Storage::disk('estates')->url($path))
                ->values()
                ->all();
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * Première photo depuis le disque "estates" (bucket agicom), comme qr-switch.
     */
    private function thumbnail(SweepbrightEstate $estate): ?string
    {
        try {
            $path = $estate->id.'/1.jpg';

            return Storage::disk('estates')->exists($path)
                ? Storage::disk('estates')->url($path)
                : null;
        } catch (Throwable) {
            return null;
        }
    }

    private function mapType(?string $type): string
    {
        return match ($type) {
            'house' => 'Maison',
            'apartment' => 'Appartement',
            'parking' => 'Parking',
            'land' => 'Terrain',
            'commercial' => 'Local commercial',
            'office' => 'Bureaux',
            default => filled($type) ? ucfirst((string) $type) : 'Bien',
        };
    }

    private function normalizeClass(mixed $value): ?string
    {
        $class = strtoupper((string) $value);

        return in_array($class, ['A', 'B', 'C', 'D', 'E', 'F', 'G'], true) ? $class : null;
    }

    private function mapStatut(string $marketStatus): string
    {
        return match ($marketStatus) {
            'sold' => 'vendu',
            'rented' => 'loue',
            'agreement' => 'sous_offre',
            'let' => 'a_louer',
            default => 'a_vendre',
        };
    }
}
