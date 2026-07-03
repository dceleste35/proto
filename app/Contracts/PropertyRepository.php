<?php

namespace App\Contracts;

use App\Support\Imports\PropertyData;
use App\Support\Imports\PropertyListItem;
use Illuminate\Support\Collection;

interface PropertyRepository
{
    /**
     * Récupère un bien par son identifiant SweepBright (estate id).
     */
    public function find(string $estateId): ?PropertyData;

    /**
     * Liste les biens d'une agence (par office_id SweepBright).
     *
     * @return Collection<int, PropertyListItem>
     */
    public function estatesForOffice(string $officeId, int $limit = 30): Collection;
}
