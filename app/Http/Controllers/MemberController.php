<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PlayerProfile;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    /**
     * Mostrar listado de miembros con filtros y búsqueda
     */
    public function index(Request $request)
    {
        $query = User::with(['playerProfile', 'roles']);

        // Búsqueda por nombre o email
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($role = $request->input('role')) {
            $query->whereHas('roles', function($q) use ($role) {
                $q->where('slug', $role);
            });
        }

        // Filtro por posición
        if ($position = $request->input('position')) {
            $query->whereHas('playerProfile', function($q) use ($position) {
                $q->where('position', $position);
            });
        }

        // Ordenar por
        $orderBy = $request->input('order_by', 'name');
        $order = $request->input('order', 'asc');
        $query->orderBy($orderBy, $order);

        $members = $query->paginate(10);
        $roles = Role::all();

        return view('members.index', compact('members', 'roles'));
    }

    /**
     * Mostrar perfil de miembro
     */
    public function show(User $user)
    {
        $user->load(['playerProfile', 'roles']);
        
        // Obtener estadísticas básicas
        $stats = [
            'trainings_attended' => 0, // Implementar cuando tengamos el módulo de entrenamientos
            'tournaments_played' => 0, // Implementar cuando tengamos el módulo de torneos
            'payment_status' => 'Al día', // Implementar cuando tengamos el módulo de pagos
        ];

        return view('members.show', compact('user', 'stats'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(User $user)
    {
        $this->authorize('edit', $user); // Implementar política de autorización
        $user->load(['playerProfile', 'roles']);
        $availableRoles = Role::all();
        $availableNumbers = $this->getAvailableJerseyNumbers($user);

        return view('members.edit', compact('user', 'availableRoles', 'availableNumbers'));
    }

    /**
     * Actualizar perfil de miembro
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('edit', $user); // Implementar política de autorización

        $validated = $request->validate([
            'position' => 'nullable|string|in:handler,cutter,both',
            'jersey_number' => [
                'nullable',
                'integer',
                'min:0',
                'max:99',
                function ($attribute, $value, $fail) use ($user) {
                    if ($this->isJerseyNumberTaken($value, $user)) {
                        $fail('Este número de dorsal ya está en uso.');
                    }
                },
            ],
            'height' => 'nullable|integer|min:100|max:250',
            'gender' => 'nullable|string|in:male,female,other',
            'experience_years' => 'nullable|integer|min:0',
            'speed_rating' => 'nullable|integer|min:1|max:10',
            'endurance_rating' => 'nullable|integer|min:1|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'roles' => 'array|exists:roles,id'
        ]);

        try {
            DB::transaction(function () use ($user, $validated, $request) {
                // Actualizar perfil
                $user->playerProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    collect($validated)->except('roles')->toArray()
                );

                // Actualizar roles si el usuario tiene permiso
                if (auth()->user()->hasRole('captain') && $request->has('roles')) {
                    $user->roles()->sync($request->input('roles'));
                }
            });

            return redirect()->route('members.show', $user)
                ->with('success', 'Perfil actualizado correctamente');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el perfil. Por favor, inténtalo de nuevo.');
        }
    }

    /**
     * Verificar si un número de dorsal está disponible
     */
    private function isJerseyNumberTaken($number, $excludeUser = null)
    {
        $query = PlayerProfile::where('jersey_number', $number);
        
        if ($excludeUser) {
            $query->where('user_id', '!=', $excludeUser->id);
        }

        return $query->exists();
    }

    /**
     * Obtener números de dorsal disponibles
     */
    private function getAvailableJerseyNumbers($excludeUser = null)
    {
        $takenNumbers = PlayerProfile::where('jersey_number', '!=', null)
            ->when($excludeUser, function ($query) use ($excludeUser) {
                return $query->where('user_id', '!=', $excludeUser->id);
            })
            ->pluck('jersey_number')
            ->toArray();

        return array_diff(range(0, 99), $takenNumbers);
    }
}