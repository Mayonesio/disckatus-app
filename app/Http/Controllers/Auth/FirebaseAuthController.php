<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Role;  // Añadimos esta importación
use Illuminate\Support\Facades\Auth;
use Exception;

class FirebaseAuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => encrypt('dummy-password')
                ]
            );
    
            // Asignar rol de jugador por defecto si no tiene ninguno
            if (!$user->roles()->exists()) {
                $playerRole = Role::where('slug', 'player')->first();
                if (!$playerRole) {
                    // Si no existe el rol, ejecutar el seeder
                    \Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
                    $playerRole = Role::where('slug', 'player')->first();
                }
                $user->roles()->attach($playerRole->id);
            }
    
            // Crear perfil si no existe
            if (!$user->playerProfile) {
                $user->playerProfile()->create();
            }
    
            Auth::login($user);
            
            return redirect()->route('dashboard');
    
        } catch (Exception $e) {
            \Log::error('Error en login con Google: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión con Google');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}