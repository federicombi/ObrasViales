<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MachineModel;
use App\Models\MachineType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modelito = MachineModel::inRandomOrder()->first();
        $code = $modelito->machine_type->code;
        $numero = fake()->bothify('###');
        $serie = $code.'-'.$numero;
        return [
            'series' => $serie,
            'machine_model_id' => $modelito->id,
            'machine_status_id' => fake()->boolean(50)? fake()->numberBetween(2, 5): 1,
        ];
    }
}
