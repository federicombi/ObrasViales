<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; /// ESTO CUANDO NO SE USA FACTORY


class ProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->insert([
            ['name' => 'Entre Ríos'],
            ['name' => 'Mendoza'],
            ['name' => 'Salta'],
            ['name' => 'Río Negro'],
        ]);
    }
}
