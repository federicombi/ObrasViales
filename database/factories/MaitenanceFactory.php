<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maitenance>
 */
class MaitenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('-100 weeks', '-10 weeks');
        $cantidad_de_dias = fake()->numberBetween(1, 15);

        //// Seedear por tipo de mantenimiento.

        return [
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $start_date->modify('+'.$cantidad_de_dias.' days')->format('Y-m-d'),
            'machine_id' => fake()->numberBetween(1, 10),
            'maitenance_type_id' => fake()->numberBetween(1, 4),
        ];
    }
}
