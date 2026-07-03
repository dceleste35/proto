<?php

namespace App\Support\Imports;

/**
 * DTO interne découplant le proto des DTO Télémaque.
 */
final readonly class AdvisorData
{
    public function __construct(
        public string $nom,
        public ?string $telephone,
        public ?string $photoUrl,
        public string $email,
    ) {}
}
