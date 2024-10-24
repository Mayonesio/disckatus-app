<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Primero ejecutamos el seeder de roles
        $this->call([
            RoleSeeder::class
        ]);

        // Mantenemos el usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Si quieres, podemos asignarle un rol al usuario de prueba
        $user = User::where('email', 'test@example.com')->first();
        $adminRole = \App\Models\Role::where('slug', 'super-admin')->first();
        $user->roles()->attach($adminRole);

        // El factory de usuarios está comentado, pero podrías descomentarlo
        // si necesitas datos de prueba
        // User::factory(10)->create();
    }
}