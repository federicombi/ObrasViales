<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Construction>
 */
class ConstructionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {   
        $start_date = fake()->dateTimeBetween('-2 years', '-4 weeks');
        $end_date = fake()->boolean(40) ? fake()->dateTimeBetween($start_date, 'now') : null;
        
        if($end_date){
            $construction_status = fake()->boolean() ? '3' : '4';
        }else{
            $construction_status = fake()->boolean(85) ? '1' : '2';
        }

        return [
            'name' => fake()->boolean(40) ? fake()->randomElement(['Calle ', 'Avenida ', 'Boulevard ']).fake('es_AR')->streetName : (fake()->boolean()? 'Ruta '.fake()->numberBetween(5,130):'Ruta Provincial '.fake()->numberBetween(10,60)),
            'start_date' => $start_date->format('Y-m-d'),
            'initial_end_date' => fake()->dateTimeBetween('-1 week', '+4 weeks')->format('Y-m-d'),
            'end_date' => $end_date,
            'region_id'=> fake()->numberBetween(1, 12),
            'construction_status_id' => $construction_status,
        ];
    }
}
