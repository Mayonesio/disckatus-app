<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class CheckUserRoles extends Command
{
    protected $signature = 'roles:check {--force : Forzar la asignación del primer usuario como super-admin}';
    protected $description = 'Verifica y corrige los roles de los usuarios';

    public function handle()
    {
        $this->info('Iniciando verificación de roles...');

        try {
            // Crear roles básicos
            $roles = [
                ['slug' => 'super-admin', 'name' => 'Super Admin', 'description' => 'Control total del sistema'],
                ['slug' => 'captain', 'name' => 'Capitán', 'description' => 'Gestión del equipo y jugadores'],
                ['slug' => 'sotg-captain', 'name' => 'Capitán SOTG', 'description' => 'Gestión del espíritu de juego'],
                ['slug' => 'player', 'name' => 'Jugador', 'description' => 'Miembro regular del equipo']
            ];

            foreach ($roles as $roleData) {
                $role = Role::firstOrCreate(
                    ['slug' => $roleData['slug']],
                    $roleData
                );
                $this->info("✓ Rol {$roleData['name']} verificado/creado");
            }

            // Verificar si existe un super-admin
            $hasAdmin = Role::where('slug', 'super-admin')->first()->users()->exists();
            
            if (!$hasAdmin) {
                // Obtener el primer usuario por fecha de creación
                $firstUser = User::orderBy('created_at')->first();
                if ($firstUser) {
                    // Remover roles actuales y asignar super-admin
                    $firstUser->roles()->detach();
                    $firstUser->roles()->attach(Role::where('slug', 'super-admin')->first()->id);
                    $this->info("\n→ Asignando rol super-admin al primer usuario: {$firstUser->email}");
                }
            }

            // Verificar usuarios sin rol
            $usersWithoutRole = User::whereDoesntHave('roles')->get();
            
            if ($usersWithoutRole->count() > 0) {
                $this->info("\nAsignando roles a usuarios sin rol:");
                foreach ($usersWithoutRole as $user) {
                    $role = Role::where('slug', 'player')->first();
                    $user->roles()->attach($role->id);
                    $this->info("→ Asignando rol player a: {$user->email}");
                }
            } else {
                $this->info("\n✓ Todos los usuarios tienen roles asignados");
            }

            // Mostrar resumen
            $this->info("\nResumen:");
            foreach ($roles as $roleData) {
                $count = Role::where('slug', $roleData['slug'])->first()->users()->count();
                $this->info("- {$roleData['name']}: {$count} usuarios");
            }

            $this->info("\n¡Verificación completada con éxito!");

        } catch (\Exception $e) {
            $this->error("Error durante la verificación: " . $e->getMessage());
        }
    }
}