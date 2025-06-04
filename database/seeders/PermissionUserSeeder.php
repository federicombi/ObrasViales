<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Permission;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions_ids = Permission::pluck('id')->toArray();
        
        $usuarios = User::all();
        foreach ($usuarios as $user) {
            $user->permissions()->attach(fake()->randomElement($permissions_ids)); ///el paremetro del attach() es el ID del rol que se asigna al user.
        }
    }
}
