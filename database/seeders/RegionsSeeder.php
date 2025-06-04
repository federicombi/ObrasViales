<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RegionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->insert([
            ['name' => 'Parana', 'province_id' => 1],
            ['name' => 'Gualeguaychu', 'province_id' => 1],
            ['name' => 'Concordia', 'province_id' => 1],

            ['name' => 'Godoy Cruz', 'province_id' => 2],
            ['name' => 'San Rafael', 'province_id' => 2],
            ['name' => 'Maipu', 'province_id' => 2],

            ['name' => 'Capital', 'province_id' => 3],
            ['name' => 'Oran', 'province_id' => 3],
            ['name' => 'Metan', 'province_id' => 3],

            ['name' => 'General Roca', 'province_id' => 4],
            ['name' => 'Bariloche', 'province_id' => 4],
            ['name' => 'Viedma', 'province_id' => 4],
        ]);
    }
}
