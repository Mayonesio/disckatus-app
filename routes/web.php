<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\MemberController;
// Añadiremos los otros controladores cuando los creemos

// Rutas de autenticación
Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('auth/google', [FirebaseAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [FirebaseAuthController::class, 'handleGoogleCallback']);
Route::post('logout', [FirebaseAuthController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
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
    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/{user}', [MemberController::class, 'show'])->name('members.show');
    Route::get('/members/{user}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::put('/members/{user}', [MemberController::class, 'update'])->name('members.update');

    // Rutas temporales (placeholder) hasta que creemos los controladores
    Route::get('/tournaments', function () {
        return view('tournaments.index');
    })->name('tournaments');

    Route::get('/payments', function () {
        return view('payments.index');
    })->name('payments');

    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');
});