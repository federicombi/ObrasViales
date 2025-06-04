<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MachineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('machine_types')->insert([
            ['name' => 'Excavadora',  'code'=>'EXC'],
            ['name' => 'Motoniveladora', 'code'=>'MN'],
            ['name' => 'Grua',  'code'=>'GR'],
            ['name' => 'Topadora',  'code'=>'TOP'],
            ['name' => 'Compactador',  'code'=>'COM'],
            ['name' => 'Martillo Hidráulico', 'code'=>'MAH'],
        ]);
    }
}
