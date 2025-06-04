<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            //ProvincesSeeder::class, 
            //RegionsSeeder::class,
            //ConstructionStatusesSeeder::class, 
            //ConstructionsSeeder::class,
            //MachineBrandSeeder::class,
            //MachineTypeSeeder::class, 
            //MachineModelSeeder::class,
            //MachineStatusesSeeder::class,
            //MachineSeeder::class,
            //AllocationEndMotivesSeeder::class,
            //AllocationsSeeder::class,
            //MaitenanceTypeSeeder::class, 
            //MaitenancesSeeder::class,
            TrailsSeeder::class,
            //UsersSeeder::class, 
            //PermissionsSeeder::class, 
            //PermissionUserSeeder::class,
        ]); 

    }
    
}
