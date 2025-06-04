<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Allocation;
use Illuminate\Support\Facades\Log;


class AllocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {
            try {
                Allocation::factory()->create();
            } catch (\Exception $e) {
                Log::warning("Error al crear el registro #$i: " . $e->getMessage());
                continue;
            }
        }
        
    }
}
