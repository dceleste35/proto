<?php

namespace App\Support\Imports;

/**
 * DTO interne découplant le proto des DTO SweepBright.
 * Ne porte que les champs pertinents pour l'affiche vitrine.
 */
final readonly class PropertyData
{
    public function __construct(
        public string $ville,
        public string $typeBien,
        public string $pieces,
        public ?int $surface,
        public ?int $prix,
        public ?string $dpeClasse,   // null = ne pas écraser (SweepBright peut renvoyer "not_applicable")
        public ?int $dpeValeur,
        public ?string $gesClasse,
        public ?int $gesValeur,
        public string $accroche,
        public string $description,
        public string $statut,       // valeur d'App\Enums\Statut
        public ?string $photoUrl,
        public ?string $reference,
        public ?string $negotiatorEmail = null, // lien vers le conseiller Télémaque
        /** @var array<int, string> URL des photos du bien (bucket) */
        public array $photos = [],
        public ?string $propertyUrl = null,    // lien public du bien (cible du QR)
    ) {}
}
