<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Construction;
use App\Models\Machine;
use Illuminate\Support\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allocation>
 */
class AllocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        
        $registro = $this->obtener_registro();
        $intentos = 1;
        while(($registro === []) && $intentos<4){ 
            $registro = $this->obtener_registro();
            $intentos++; 
        }
        return $registro;
    }

    protected function es_posible_agregar_allocation($allocations, $tope_inicio): ?Carbon 
    {
        if ($allocations->isNotEmpty()) {
            $primera_allocation = $allocations->sortBy('start_date')->first(); //// se considera la primer asignación de la maquina de siempre
            if($primera_allocation->end_date === null){ ///// comprobar si la primera de todas está abierta.
                return null;
            }else{
                $siguiente_allocation = $allocations->sortByDesc('start_date')->first(); // comprobar que la ultima en abrirse no este abierta aún
                if($siguiente_allocation->end_date === null){
                    return null;
                }else{
                    $ultima_allocation = $allocations->whereNotNull('end_date')->sortByDesc('end_date')->first();
                    return Carbon::instance($ultima_allocation->end_date)->addDay(); 
                } 
            }
           
        } else {
            return $tope_inicio->addDay();
        }
    }

    protected function obtener_registro(): ? array 
    {
        $obra = Construction::inRandomOrder()->first();
        $inicio_de_la_obra = $obra->start_date; 
        $fin_de_la_obra = $obra->end_date;

        $maquina = Machine::with('allocations')->inRandomOrder()->first();
        $allocations_existentes = $maquina->allocations;

        $tope_de_inicio_de_allocation_nueva = $this->es_posible_agregar_allocation($allocations_existentes, $inicio_de_la_obra);

        if ($tope_de_inicio_de_allocation_nueva === null) {
            return []; /// si la allocation no es posible, devuelve el array vacío.
        }

        $start_date = null;
        $end_date = null;
        $end_motive_id = null;

        if ($fin_de_la_obra !== null) { //// si la obra tiene end_date definido

            if ($tope_de_inicio_de_allocation_nueva->greaterThanOrEqualTo($fin_de_la_obra)) {
                return []; //// si la fecha de inicio es mayor o igual al fin de la obra.
            } else {
                // El rango de fechas está ok
                $start_date = fake()->dateTimeBetween($tope_de_inicio_de_allocation_nueva, $fin_de_la_obra)->format('Y-m-d');
                $end_date = fake()->dateTimeBetween($start_date, $fin_de_la_obra)->format('Y-m-d');
            }
            $end_motive_id = 1; 
            /////////////////// HASTA ACA SE DEFINE UNA ASIGNACIÓN QUE TERMINA en caso de obras que terminaron.
        } else {
            // La obra no tiene fecha de fin: aún está en contrucción. SE CONSIDERA AHORA LA FECHA TENTATIVA
            // La allocation puede tener o no fecha de fin.
            $fin_de_la_obra = $obra->initial_end_date;
            $end_motive_id = fake()->randomElement([null, 1, 2, 3, 4]);

            if ($end_motive_id !== null) { /// esta definido el motivo de cierre, o sea que la allocation terminó (antes que la obra).
                // inicio y fin entre el  tope de inicio y el fin tentativo
                $start_date = fake()->dateTimeBetween($tope_de_inicio_de_allocation_nueva, $fin_de_la_obra)->format('Y-m-d');
                $end_date = fake()->dateTimeBetween($start_date, $fin_de_la_obra)->format('Y-m-d');
                    //// Hasta ACÁ se agregan si la obra no tiene fecha de fin, las allocation que TERMINARON
            } else { //// NO está definido el motivo de cierre, la allocation en creación aún es abierta.
                $start_date = fake()->dateTimeBetween($tope_de_inicio_de_allocation_nueva, $fin_de_la_obra)->format('Y-m-d');
                $end_date = null;
            }
        }
        
        return [
            'start_date' => $start_date,
            'end_date' => $end_date, 
            'machine_id' => $maquina->id,
            'construction_id' => $obra->id,
            'allocation_end_motive_id' => $end_motive_id,
        ];
    }

    /*
    public function definition(): array
    {
        
        $registro = $this->obtener_registro();
        while(!$registro){
            $registro = obtener_registro();
        }

        return $registro; 
    }

    protected function es_posible_agregar_allocation($allocations, $tope_inicio): ?Carbon
    {
        if ($allocations->isNotEmpty()) {
            // Obtener la última allocation por fecha
            $ultima = $allocations->sortByDesc('end_date')->first();

            if ($ultima->end_date === null) {
                return null; // Hay una allocation abierta → no se puede agregar otra
            }else{
                return $ultima->end_date;
            }

            
        }else{
            // No hay allocations previas, se puede usar el tope original
            return $tope_inicio;
        }

        
        
    }


    protected function obtener_registro(): ?array
    {
        $obra = Construction::inRandomOrder()->first();
        $limite_inicio = $obra->start_date;
        $limite_fin = $obra->end_date;

        $maquina = Machine::with('allocations')->inRandomOrder()->first();
        $allocations = $maquina->allocations;

        $limite_inicio = $this->es_posible_agregar_allocation($allocations, $limite_inicio);
        
        if($limite_inicio){
            if($limite_fin != null){
                $end_motive_id = 1;
                $allocation_end_date = fake()->dateTimeBetween($limite_inicio, $limite_fin);
                $start_date = fake()->dateTimeBetween($limite_inicio, $allocation_end_date);
                $end_date = $allocation_end_date->format('Y-m-d');
            }else{
                $end_motive_id = fake()->randomElement([null, 1, 2, 3, 4]);
                if($end_motive_id != null){
                    $allocation_end_date = fake()->dateTimeBetween($limite_inicio, $limite_fin);
                    $start_date = fake()->dateTimeBetween($limite_inicio, $allocation_end_date);
                    $end_date = $allocation_end_date->format('Y-m-d');
                }else{
                    $end_date = null;
                    $start_date = fake()->dateTimeBetween($limite_inicio, 'now');
                }
            }
            return [
                'start_date' => $start_date->format('Y-m-d'),
                'end_date' => $end_date,
                'machine_id'=> $maquina->id,
                'construction_id'=> $obra->id,
                'allocation_end_motive_id'=> $end_motive_id,
            ];
        }else{
            return false;
        }
        

    }
    */
}
