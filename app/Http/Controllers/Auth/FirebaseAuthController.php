<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
            
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'password' => encrypt('dummy-password')
                ]
            );
    
            Auth::login($user);
            
            // Redirigir al dashboard con datos iniciales
            return redirect()->route('dashboard');
    
        } catch (Exception $e) {
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