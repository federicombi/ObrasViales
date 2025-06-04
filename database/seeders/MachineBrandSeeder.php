<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('machine_brands')->insert([
            ['name' => 'Caterpillar'],
            ['name' => 'John Deere'],
            ['name' => 'Volvo'],
            ['name' => 'Komatsu'],
        ]);
    }
}
