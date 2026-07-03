<?php

namespace App\Enums;

/**
 * Emplacement du QR code sur l'affiche.
 */
enum QrPosition: string
{
    case HautDroite = 'haut_droite';
    case BasGauche = 'bas_gauche';
    case Aucun = 'aucun';

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return [
            self::HautDroite->value => 'Haut droite (sur la photo)',
            self::BasGauche->value => 'Bas gauche (colonne)',
            self::Aucun->value => 'Aucun',
        ];
    }
}
