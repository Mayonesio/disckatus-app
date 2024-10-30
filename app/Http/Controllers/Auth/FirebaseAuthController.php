<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class FirebaseAuthController extends Controller
{
    // Quitamos el constructor que dependía de Firebase
    // y la propiedad $auth

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Crear o actualizar usuario
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => encrypt('dummy-password')
                ]
            );

            // Asignar rol si no tiene ninguno
            if (!$user->roles()->exists()) {
                $isFirstUser = User::count() === 1;
                
                if ($isFirstUser) {
                    // El primer usuario será super-admin
                    $role = Role::firstOrCreate(
                        ['slug' => 'super-admin'],
                        ['name' => 'Super Admin', 'description' => 'Control total del sistema']
                    );
                } else {
                    // Los demás usuarios serán players por defecto
                    $role = Role::firstOrCreate(
                        ['slug' => 'player'],
                        ['name' => 'Player', 'description' => 'Miembro regular del equipo']
                    );
                }
                
                $user->roles()->attach($role->id);
                Log::info('Role assigned to user', [
                    'user_id' => $user->id,
                    'role' => $role->slug
                ]);
            }

            Auth::login($user);
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('Error in Google authentication:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('login')
                ->with('error', 'Error al iniciar sesión con Google: ' . $e->getMessage());
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}