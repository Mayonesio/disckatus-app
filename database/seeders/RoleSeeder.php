<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Control total del sistema'
            ],
            [
                'name' => 'Capitán',
                'slug' => 'captain',
                'description' => 'Gestión del equipo y jugadores'
            ],
            [
                'name' => 'Capitán SOTG',
                'slug' => 'sotg-captain',
                'description' => 'Gestión del espíritu de juego'
            ],
            [
                'name' => 'Jugador',
                'slug' => 'player',
                'description' => 'Miembro regular del equipo'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}