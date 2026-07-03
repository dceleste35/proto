<?php

namespace Database\Seeders;

use App\Models\Affiche;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $base = [
            'ville' => 'Yerres',
            'type_bien' => 'Maison',
            'pieces' => '5 pièces',
            'surface' => 132,
            'prix' => 419000,
            'dpe_classe' => 'C',
            'dpe_valeur' => 85,
            'ges_classe' => 'C',
            'ges_valeur' => 15,
            'accroche' => 'Le + : Jardin paysagé de 800 m²',
            'description' => "Charmante maison construite en 1974 offrant de beaux volumes sur un terrain de taille généreuse. Bénéficiant d'une orientation sud, elle se compose d'une entrée spacieuse, d'un large salon/séjour traversant de 31 m² avec accès à une terrasse et un balcon, et d'une cuisine équipée. A l'étage quatre chambres et deux salles de bains…",
            'mentions_legales' => "Honoraires charge vendeur. Montant estimé des dépenses annuelles d'énergie pour un usage standard : Entre 1680€ et 2340€/an. Année de référence des prix de l'énergie:2021.",
            'agent_nom' => 'Thomas Dupond (EI)',
            'agent_telephone' => '06 08 04 97 47',
            'qr_url' => 'https://www.orpi.com',
        ];

        // Les 4 variantes du PDF de référence.
        Affiche::create([...$base, 'statut' => 'a_vendre', 'qr_position' => 'haut_droite', 'agent_visible' => true]);
        Affiche::create([...$base, 'statut' => 'a_vendre', 'qr_position' => 'bas_gauche', 'agent_visible' => false]);
        Affiche::create([...$base, 'statut' => 'vendu_en_jours', 'statut_jours' => 17, 'qr_position' => 'aucun', 'agent_visible' => true]);
        Affiche::create([...$base, 'statut' => 'deja_vendu', 'qr_position' => 'bas_gauche', 'agent_visible' => false]);
    }
}
