<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\MemberController;

// Rutas públicas
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('auth/google', [FirebaseAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [FirebaseAuthController::class, 'handleGoogleCallback']);

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard accesible para todos los usuarios autenticados
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'totalMembers' => 15,
            'newMembersThisMonth' => 2,
            'upcomingTournaments' => collect([
                (object)['name' => 'Torneo de Otoño', 'date' => now()->addDays(15)],
                (object)['name' => 'Liga Madrid', 'date' => now()->addDays(30)]
            ]),
            'paymentPercentage' => 75,
            'overduePayments' => 3
        ]);
    })->name('dashboard');

    // Rutas de miembros
    Route::group(['prefix' => 'members', 'as' => 'members.'], function () {
        // Rutas accesibles para todos los usuarios autenticados
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/{user}', [MemberController::class, 'show'])->name('show');
        
        // Rutas que requieren ser capitán
        Route::group(['middleware' => 'auth'], function () {
            Route::get('/{user}/edit', [MemberController::class, 'edit'])
                ->name('edit')
                ->middleware('can:edit,user');
                
            Route::put('/{user}', [MemberController::class, 'update'])
                ->name('update')
                ->middleware('can:edit,user');
                
            Route::put('/{user}/avatar', [MemberController::class, 'updateAvatar'])
                ->name('update-avatar')
                ->middleware('can:edit,user');
        });
    });

    // Rutas solo para capitanes
    Route::group(['middleware' => 'can:manage-team'], function () {
        Route::get('/tournaments', function () {
            return view('tournaments.index');
        })->name('tournaments');

        Route::get('/payments', function () {
            return view('payments.index');
        })->name('payments');
    });

    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');

    Route::post('logout', [FirebaseAuthController::class, 'logout'])->name('logout');
});