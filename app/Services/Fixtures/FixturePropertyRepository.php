<?php

namespace App\Services\Fixtures;

use App\Contracts\PropertyRepository;
use App\Support\Imports\PropertyData;
use App\Support\Imports\PropertyListItem;
use Illuminate\Support\Collection;

/**
 * Source de biens factice (données réalistes en dur) pour faire tourner
 * le proto sans credentials SweepBright. Indexée par pseudo estate id.
 */
class FixturePropertyRepository implements PropertyRepository
{
    public function find(string $estateId): ?PropertyData
    {
        return $this->estates()[strtoupper(trim($estateId))] ?? null;
    }

    public function estatesForOffice(string $officeId, int $limit = 30): Collection
    {
        return collect($this->estates())
            ->take($limit)
            ->map(fn (PropertyData $e, string $id): PropertyListItem => new PropertyListItem(
                id: $id,
                ville: $e->ville,
                typeBien: $e->typeBien,
                prix: $e->prix,
                reference: $e->reference,
                statut: $e->statut,
                thumbnailUrl: $e->photoUrl,
            ))
            ->values();
    }

    /**
     * @return array<string, PropertyData>
     */
    private function estates(): array
    {
        return [
            'DEMO-001' => new PropertyData(
                ville: 'Yerres',
                typeBien: 'Maison',
                pieces: '5 pièces',
                surface: 132,
                prix: 419000,
                dpeClasse: 'C',
                dpeValeur: 85,
                gesClasse: 'C',
                gesValeur: 15,
                accroche: 'Le + : Jardin paysagé de 800 m²',
                description: "Charmante maison construite en 1974 offrant de beaux volumes sur un terrain de taille généreuse. Bénéficiant d'une orientation sud, elle se compose d'une entrée spacieuse, d'un large salon/séjour traversant de 31 m² avec accès à une terrasse et un balcon, et d'une cuisine équipée. A l'étage quatre chambres et deux salles de bains.",
                statut: 'a_vendre',
                photoUrl: 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=1400&q=80',
                reference: 'MDT-2024-001',
                negotiatorEmail: 'thomas.dupond@orpi.com',
                propertyUrl: 'https://www.orpi.com/estate/DEMO-001',
            ),
            'DEMO-002' => new PropertyData(
                ville: 'Saint-Denis',
                typeBien: 'Appartement',
                pieces: '3 pièces',
                surface: 68,
                prix: 289000,
                dpeClasse: 'D',
                dpeValeur: 178,
                gesClasse: 'D',
                gesValeur: 34,
                accroche: 'Le + : Balcon plein sud & parking',
                description: 'Au 4e étage avec ascenseur, appartement lumineux de 68 m² comprenant un séjour donnant sur un balcon exposé sud, une cuisine aménagée, deux chambres et une salle de bains. Cave et place de parking en sous-sol. Proche transports et commerces.',
                statut: 'a_vendre',
                photoUrl: 'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?w=1400&q=80',
                reference: 'MDT-2024-018',
                negotiatorEmail: 'marie.lefebvre@orpi.com',
                propertyUrl: 'https://www.orpi.com/estate/DEMO-002',
            ),
            'DEMO-003' => new PropertyData(
                ville: 'Rennes',
                typeBien: 'Maison',
                pieces: '6 pièces',
                surface: 165,
                prix: 574000,
                dpeClasse: 'B',
                dpeValeur: 92,
                gesClasse: 'A',
                gesValeur: 6,
                accroche: 'Le + : Rénovation complète 2023',
                description: 'Belle maison contemporaine entièrement rénovée en 2023, alliant confort et performance énergétique. Vaste pièce de vie de 45 m² ouverte sur cuisine équipée, quatre chambres dont une suite parentale, bureau et double garage. Jardin clos et arboré de 500 m².',
                statut: 'vendu_en_jours',
                photoUrl: 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=1400&q=80',
                reference: 'MDT-2024-042',
                negotiatorEmail: 'julien.martin@orpi.com',
                propertyUrl: 'https://www.orpi.com/estate/DEMO-003',
            ),
        ];
    }
}
