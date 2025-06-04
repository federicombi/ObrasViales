<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllocationEndMotivesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('allocation_end_motives')->insert([
            ['motive' => 'Tarea completada'],
            ['motive' => 'Rotura'],
            ['motive' => 'Mantenimiento'],
            ['motive' => 'Reasignacion'],
        ]);
    }
}
