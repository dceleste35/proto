<?php

namespace App\Enums;

/**
 * Statut commercial affiché sur le badge de l'affiche vitrine.
 */
enum Statut: string
{
    case AVendre = 'a_vendre';
    case SousOffre = 'sous_offre';
    case Vendu = 'vendu';
    case VenduEnJours = 'vendu_en_jours';
    case DejaVendu = 'deja_vendu';
    case ALouer = 'a_louer';
    case Loue = 'loue';
    case Nouveaute = 'nouveaute';
    case BaissePrix = 'baisse_prix';

    /**
     * Libellé du badge. {jours} est remplacé par le nombre de jours pour VenduEnJours.
     */
    public function label(?int $jours = null): string
    {
        return match ($this) {
            self::AVendre => 'À VENDRE',
            self::SousOffre => 'SOUS OFFRE',
            self::Vendu => 'VENDU',
            self::VenduEnJours => 'VENDU en '.($jours ?? 0).' jour'.(($jours ?? 0) > 1 ? 's' : ''),
            self::DejaVendu => 'DÉJÀ VENDU',
            self::ALouer => 'À LOUER',
            self::Loue => 'LOUÉ',
            self::Nouveaute => 'NOUVEAUTÉ',
            self::BaissePrix => 'BAISSE DE PRIX',
        };
    }

    /**
     * Couleur de fond du badge (charte : rouge = disponible, violet = conclu).
     */
    public function couleur(): string
    {
        return match ($this) {
            self::AVendre, self::ALouer, self::Nouveaute, self::BaissePrix => '#E2001A',
            self::SousOffre => '#F39200',
            self::Vendu, self::VenduEnJours, self::DejaVendu, self::Loue => '#6C5B9E',
        };
    }

    /**
     * Affiche l'icône « maison € » (uniquement les statuts « disponible »).
     */
    public function afficheIcone(): bool
    {
        return in_array($this, [self::AVendre, self::ALouer, self::Nouveaute], true);
    }

    /**
     * Ce statut nécessite un nombre de jours saisissable.
     */
    public function requiertJours(): bool
    {
        return $this === self::VenduEnJours;
    }

    /**
     * @return array<string, string> valeur => libellé générique (pour un <select>)
     */
    public static function options(): array
    {
        return [
            self::AVendre->value => 'À vendre',
            self::SousOffre->value => 'Sous offre',
            self::Vendu->value => 'Vendu',
            self::VenduEnJours->value => 'Vendu en X jours',
            self::DejaVendu->value => 'Déjà vendu',
            self::ALouer->value => 'À louer',
            self::Loue->value => 'Loué',
            self::Nouveaute->value => 'Nouveauté',
            self::BaissePrix->value => 'Baisse de prix',
        ];
    }
}
