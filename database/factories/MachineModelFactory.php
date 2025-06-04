<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\MachineType;
use App\Models\MachineBrand;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MachineModel>
 */
class MachineModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->bothify('?##'),
            'machine_brand_id' => MachineBrand::inRandomOrder()->first()->id,
            'machine_type_id' => MachineType::inRandomOrder()->first()->id,
        ];
    }
}
