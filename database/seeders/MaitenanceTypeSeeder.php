<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaitenanceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('maitenance_types')->insert([
            ['name' => 'Cambio de aceite y filtros',  'km_limit'=>5000],
            ['name' => 'Reajuste de cadenas',  'km_limit'=>20000],
            ['name' => 'Control de refrigeración',  'km_limit'=>15000],
            ['name' => 'Cambio de liquido de Frenos',  'km_limit'=>50000],
            ['name' => 'Pintura',  'km_limit'=>200000],
        ]);
    }
}
