<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\FirebaseAuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\AdminController;

// Rutas públicas
Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::get('auth/google', [FirebaseAuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [FirebaseAuthController::class, 'handleGoogleCallback']);

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        // Obtener estadísticas reales
        $totalMembers = \App\Models\User::count();
        $newMembersThisMonth = \App\Models\User::whereMonth('created_at', now()->month)->count();
        
        return view('dashboard', [
            'totalMembers' => $totalMembers,
            'newMembersThisMonth' => $newMembersThisMonth,
            'upcomingTournaments' => collect([
                (object)['name' => 'Torneo de Otoño', 'date' => now()->addDays(15)],
                (object)['name' => 'Liga Madrid', 'date' => now()->addDays(30)]
            ]),
            'paymentPercentage' => 75,
            'overduePayments' => 3
        ]);
    })->name('dashboard');

    // Rutas de miembros
    Route::prefix('members')->name('members.')->group(function () {
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/create', [MemberController::class, 'create'])
            ->middleware('role:super-admin,captain')
            ->name('create');
        Route::post('/', [MemberController::class, 'store'])
            ->middleware('role:super-admin,captain')
            ->name('store');
        Route::get('/{user}', [MemberController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [MemberController::class, 'edit'])
            ->middleware('can:edit,user')
            ->name('edit');
        Route::put('/{user}', [MemberController::class, 'update'])
            ->middleware('can:edit,user')
            ->name('update');
        Route::post('/{user}/avatar', [MemberController::class, 'updateAvatar'])
            ->middleware('can:edit,user')
            ->name('update-avatar');
    });

    // Rutas de administración
    Route::middleware(['role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/roles/manage', [AdminController::class, 'manageRoles'])->name('roles.manage');
        Route::put('/users/{user}/roles', [AdminController::class, 'updateUserRoles'])->name('users.roles.update');
    });

    // Rutas temporales con middleware de rol
    Route::middleware(['role:super-admin,captain'])->group(function () {
        // Rutas de torneos
        Route::prefix('tournaments')->name('tournaments.')->group(function () {
            Route::get('/', function () { return view('tournaments.index'); })->name('index');
            Route::get('/create', function () { return view('tournaments.create'); })->name('create');
        });

        // Rutas de pagos
        Route::get('/payments', function () {
            return view('payments.index');
        })->name('payments');
    });

    // Rutas de SOTG (Spirit of the Game)
    Route::middleware(['role:super-admin,sotg-captain'])->prefix('sotg')->name('sotg.')->group(function () {
        Route::get('/evaluate', function () { 
            return view('sotg.evaluate'); 
        })->name('evaluate');
    });

    // Rutas de configuración (accesible para todos los usuarios autenticados)
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings');

    Route::post('logout', [FirebaseAuthController::class, 'logout'])->name('logout');
});