<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Maitenance;
use Illuminate\Support\Facades\DB;
use App\Models\Machine;

class MaitenancesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $maquinas = Machine::with(
            'machine_status',
            'allocations'
        )->get();

        $registros = $this->agregar_mantenimiento_de_maquinas_en_reparacion($maquinas);
        
        DB::table('maitenances')->insert($registros);
    }

    protected function agregar_mantenimiento_de_maquinas_en_reparacion($maquinas):array
    {
        $registros = [];
        foreach($maquinas as $maquina){
            //// esto supone que existe allocation, puede que no haya, verificar en caso de que sea null.
            if((null != $maquina->allocations->first()) && isset($maquina->allocations->first()->end_date)){
                $id_maitenance = fake()->numberBetween(1,4);
                $machine_status = $maquina->machine_status->id;
                $start_date = $maquina->allocations->first()->end_date;
                $dias_de_mantenimiento = random_int(2, 15);
                $end_limit = (clone $start_date)->modify('+'.$dias_de_mantenimiento.' days');

                if($machine_status == '4' || $machine_status == '3'){
                    $end_date = fake()->dateTimeBetween($start_date, $end_limit);
                    $registros[] = ["start_date"=>$start_date->format('Y-m-d'),  'end_date'=>$end_date->format('Y-m-d'),  'machine_id'=>$maquina->id,  'maitenance_type_id'=>$id_maitenance];
                }
            }
        /// asociar maquina a mantenimiento ? el mantenimiento es del 1 uno hasta el tipo 4
        }
        return $registros;
    }
}
