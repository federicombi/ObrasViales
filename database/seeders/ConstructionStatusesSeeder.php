<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConstructionStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('construction_statuses')->insert([
            ['name' => 'En Actividad'],
            ['name' => 'Finalizada'],
            ['name' => 'Pausada'],
            ['name' => 'Cancelada'],
        ]);
    }
}
