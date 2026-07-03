<?php

namespace App\Contracts;

use App\Support\Imports\AdvisorData;
use Illuminate\Support\Collection;

interface AdvisorRepository
{
    /**
     * Liste les conseillers actifs d'une agence (par code Télémaque).
     *
     * @return Collection<int, AdvisorData>
     */
    public function agencyAdvisors(string $agencyCode): Collection;

    public function findByEmail(string $email): ?AdvisorData;
}
