<?php

namespace App\Services\Fixtures;

use App\Contracts\AdvisorRepository;
use App\Support\Imports\AdvisorData;
use Illuminate\Support\Collection;

/**
 * Source de conseillers factice (agence "DEMO") pour faire tourner le proto
 * sans credentials Télémaque.
 */
class FixtureAdvisorRepository implements AdvisorRepository
{
    public function agencyAdvisors(string $agencyCode): Collection
    {
        return collect($this->advisors());
    }

    public function findByEmail(string $email): ?AdvisorData
    {
        return collect($this->advisors())->firstWhere('email', $email);
    }

    /**
     * @return array<int, AdvisorData>
     */
    private function advisors(): array
    {
        return [
            new AdvisorData(
                nom: 'Thomas Dupond (EI)',
                telephone: '06 08 04 97 47',
                photoUrl: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&q=80',
                email: 'thomas.dupond@orpi.com',
            ),
            new AdvisorData(
                nom: 'Marie Lefebvre',
                telephone: '06 12 34 56 78',
                photoUrl: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&q=80',
                email: 'marie.lefebvre@orpi.com',
            ),
            new AdvisorData(
                nom: 'Julien Martin',
                telephone: '06 98 76 54 32',
                photoUrl: 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&q=80',
                email: 'julien.martin@orpi.com',
            ),
        ];
    }
}
