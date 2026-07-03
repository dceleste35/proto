<?php

namespace App\Services\Sweepbright;

use Agicom\Sweepbright\DataObjects\EstateData;
use Agicom\Sweepbright\Sweepbright;
use App\Contracts\PropertyRepository;
use App\Support\Imports\PropertyData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Throwable;

/**
 * Adaptateur SweepBright s'appuyant sur le package agicom/laravel-sweepbright.
 * Récupère un bien via la façade SDK (Sweepbright::get) et mappe le DTO EstateData
 * vers le DTO interne PropertyData consommé par l'éditeur d'affiche.
 */
class SweepbrightPropertyRepository implements PropertyRepository
{
    public function __construct(private ?Sweepbright $client = null) {}

    public function find(string $estateId): ?PropertyData
    {
        try {
            $estate = ($this->client ?? app(Sweepbright::class))->get($estateId);
        } catch (Throwable $e) {
            report($e);

            return null;
        }

        return $estate instanceof EstateData ? $this->map($estate) : null;
    }

    /**
     * L'API SweepBright n'expose pas de listing par office via GET /estates/{id} :
     * utiliser le driver "agiprint" (base partagée) pour lister les biens d'une agence.
     */
    public function estatesForOffice(string $officeId, int $limit = 30): Collection
    {
        return collect();
    }

    private function map(EstateData $estate): PropertyData
    {
        $rooms = $estate->roomCount ?? (($estate->livingRooms ?? 0) + ($estate->bedrooms ?? 0));

        return new PropertyData(
            ville: $estate->location->city ?? '',
            typeBien: $this->mapType($estate->type?->value),
            pieces: $rooms > 0 ? $rooms.' pièce'.($rooms > 1 ? 's' : '') : '',
            surface: is_numeric($estate->surface) ? (int) round((float) $estate->surface) : null,
            prix: $estate->amount !== null ? (int) round($estate->amount) : null,
            dpeClasse: $this->normalizeClass($estate->energy?->dpe),
            dpeValeur: $estate->energy?->epcValue !== null ? (int) round($estate->energy->epcValue) : null,
            gesClasse: $this->normalizeClass($estate->energy?->greenhouseEmissions),
            gesValeur: $estate->energy?->co2Emissions !== null ? (int) round($estate->energy->co2Emissions) : null,
            accroche: $estate->title->fr ?? '',
            description: Str::of($estate->description->fr ?? '')->trim()->toString(),
            statut: $this->mapStatut($estate->negotiation ?? '', $estate->status?->value),
            photoUrl: $estate->images?->first()?->url,
            reference: $estate->mandate?->number,
            negotiatorEmail: $estate->negotiator?->email,
            photos: $estate->images?->pluck('url')->filter()->map(fn ($u): string => (string) $u)->values()->all() ?? [],
            propertyUrl: $estate->id !== null ? 'https://www.orpi.com/estate/'.$estate->id : null,
        );
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

    /**
     * Renvoie A–G en majuscule, ou null si non applicable (ne pas écraser la valeur courante).
     */
    private function normalizeClass(?string $value): ?string
    {
        $class = strtoupper((string) $value);

        return in_array($class, ['A', 'B', 'C', 'D', 'E', 'F', 'G'], true) ? $class : null;
    }

    private function mapStatut(string $negotiation, ?string $status): string
    {
        return match ($status) {
            'sold' => 'vendu',
            'rented' => 'loue',
            'agreement' => 'sous_offre',
            default => $negotiation === 'let' ? 'a_louer' : 'a_vendre',
        };
    }
}
