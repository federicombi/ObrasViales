<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Trail>
 */
class TrailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $horas = fake()->numberBetween(1, 8);
        $minutos = fake()->numberBetween(10, 59);
        $tiempo_de_uso = '0'.$horas.':'.$minutos.':00';

        return [
            'km' => fake()->numberBetween(10, 400),
            'date' => fake()->dateTimeBetween('-2 years', 'now'),
            'use_time' => $tiempo_de_uso,
            'machine_id' => fake()->numberBetween(1, 10),
        ];
    }
}
