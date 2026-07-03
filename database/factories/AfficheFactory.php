<?php

namespace Database\Factories;

use App\Enums\QrPosition;
use App\Enums\Statut;
use App\Models\Affiche;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Affiche>
 */
class AfficheFactory extends Factory
{
    protected $model = Affiche::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $classes = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

        return [
            'ville' => fake()->city(),
            'type_bien' => fake()->randomElement(['Maison', 'Appartement', 'Studio', 'Terrain']),
            'pieces' => fake()->numberBetween(1, 7).' pièces',
            'surface' => fake()->numberBetween(25, 220),
            'prix' => fake()->numberBetween(90, 900) * 1000,
            'dpe_classe' => fake()->randomElement($classes),
            'dpe_valeur' => fake()->numberBetween(40, 420),
            'ges_classe' => fake()->randomElement($classes),
            'ges_valeur' => fake()->numberBetween(5, 80),
            'accroche' => 'Le + : '.fake()->randomElement(['Jardin paysagé', 'Terrasse plein sud', 'Vue dégagée', 'Garage double']),
            'description' => fake()->paragraph(4),
            'mentions_legales' => 'Honoraires charge vendeur. Montant estimé des dépenses annuelles d\'énergie pour un usage standard.',
            'statut' => fake()->randomElement(Statut::cases()),
            'statut_jours' => fake()->numberBetween(3, 60),
            'qr_position' => fake()->randomElement(QrPosition::cases()),
            'qr_url' => 'https://www.orpi.com',
            'agent_visible' => fake()->boolean(70),
            'agent_nom' => fake()->name().' (EI)',
            'agent_telephone' => '06 '.fake()->numerify('## ## ## ##'),
            'agent_photo_path' => null,
            'photo_path' => null,
        ];
    }
}
