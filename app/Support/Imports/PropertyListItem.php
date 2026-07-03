<?php

namespace App\Support\Imports;

/**
 * Élément de liste (bien d'une agence) — version légère pour la sélection.
 */
final readonly class PropertyListItem
{
    public function __construct(
        public string $id,          // estate_id, passé à PropertyRepository::find()
        public string $ville,
        public string $typeBien,
        public ?int $prix,
        public ?string $reference,
        public string $statut,      // valeur d'App\Enums\Statut
        public ?string $thumbnailUrl,
    ) {}
}
