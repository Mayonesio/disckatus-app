<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Role;

class AssignSuperAdmin extends Command
{
    protected $signature = 'roles:assign-super-admin {email}';
    protected $description = 'Asigna el rol de super-admin a un usuario por email';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("No se encontró usuario con email: {$email}");
            return 1;
        }

        $superAdminRole = Role::where('slug', 'super-admin')->first();
        if (!$superAdminRole) {
            $this->error("El rol super-admin no existe. Ejecuta primero: php artisan roles:check");
            return 1;
        }

        // Limpiar roles existentes y asignar super-admin
        $user->roles()->sync([$superAdminRole->id]);

        $this->info("¡Super Admin asignado correctamente a {$user->name}!");
        return 0;
    }
}