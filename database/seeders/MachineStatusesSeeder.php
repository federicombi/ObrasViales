<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('machine_statuses')->insert([
            ['name' => 'Disponible'],
            ['name' => 'En actividad'],
            ['name' => 'En reparación'],
            ['name' => 'En mantenimento'],
            ['name' => 'En transporte'],
        ]);
    }
}
