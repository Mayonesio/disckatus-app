<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Role;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\FirebaseStorageService;

class MemberController extends Controller
{
    public function index()
    {
        $members = User::with(['playerProfile', 'roles'])->get();
        return view('members.index', compact('members'));
    }

    public function show(User $user)
    {
        $user->load(['playerProfile', 'roles']);
        
        // Datos de ejemplo para el gráfico de rendimiento
        $performanceData = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            'speed' => [5, 6, 7, 7, 8, 8],
            'endurance' => [4, 5, 5, 6, 7, 7]
        ];

        return view('members.show', compact('user', 'performanceData'));
    }

    public function create()
{
    return view('members.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'position' => 'nullable|string|in:handler,cutter,both',
        'jersey_number' => [
            'nullable',
            'integer',
            'min:0',
            'max:99',
            function ($attribute, $value, $fail) {
                if ($this->isJerseyNumberTaken($value)) {
                    $fail('Este número de dorsal ya está en uso.');
                }
            },
        ],
        'experience_years' => 'nullable|integer|min:0',
        'speed_rating' => 'nullable|integer|min:1|max:10',
        'endurance_rating' => 'nullable|integer|min:1|max:10',
        'emergency_contact' => 'nullable|string|max:255',
        'emergency_phone' => 'nullable|string|max:20',
        'throw_levels' => 'nullable|array',
        'throw_levels.*' => 'string|in:none,basic,intermediate,master',
        'throws_notes' => 'nullable|string',
    ]);

    try {
        DB::transaction(function () use ($validated) {
            // Crear usuario
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt(Str::random(16))
            ]);

            // Asignar rol de jugador
            $playerRole = Role::where('slug', 'player')->first();
            $user->roles()->attach($playerRole->id);

            // Crear perfil
            $profileData = collect($validated)
                ->except(['name', 'email', 'throw_levels', 'throws_notes'])
                ->toArray();

            $profile = $user->playerProfile()->create($profileData);

            // Guardar lanzamientos
            if (isset($validated['throw_levels'])) {
                $profile->throw_levels = $validated['throw_levels'];
                $profile->throws_notes = $validated['throws_notes'] ?? null;
                $profile->save();
            }
        });

        return redirect()
            ->route('members.index')
            ->with('success', 'Miembro creado correctamente');

    } catch (\Exception $e) {
        return back()
            ->with('error', 'Error al crear el miembro: ' . $e->getMessage())
            ->withInput();
    }
}

    public function edit(User $user)
    {
        $user->load(['playerProfile', 'roles']);
        return view('members.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
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
            'experience_years' => 'nullable|integer|min:0',
            'speed_rating' => 'nullable|integer|min:1|max:10',
            'endurance_rating' => 'nullable|integer|min:1|max:10',
            'emergency_contact' => 'nullable|string|max:255',
            'emergency_phone' => 'nullable|string|max:20',
            'throw_levels' => 'nullable|array',
            'throw_levels.*' => 'string|in:none,basic,intermediate,master',
            'throws_notes' => 'nullable|string',
        ]);
    
        try {
            DB::transaction(function () use ($user, $validated) {
                // Actualizar perfil básico
                $profileData = collect($validated)
                    ->except(['throw_levels', 'throws_notes'])
                    ->toArray();
    
                $profile = $user->playerProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    $profileData
                );
    
                // Actualizar niveles de lanzamientos
                $profile->throw_levels = $validated['throw_levels'] ?? [];
                $profile->throws_notes = $validated['throws_notes'];
                $profile->save();
            });
    
            return redirect()
                ->route('members.show', $user)
                ->with('success', 'Perfil actualizado correctamente');
    
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateAvatar(Request $request, User $user)
    {
        try {
            $request->validate([
                'avatar' => 'required|image|max:5120', // 5MB máximo
            ]);
    
            if ($request->hasFile('avatar')) {
                $firebaseStorage = app(FirebaseStorageService::class);
    
                // Eliminar avatar anterior si existe y no es de Google
                if ($user->avatar && !filter_var($user->avatar, FILTER_VALIDATE_URL)) {
                    $firebaseStorage->deleteAvatar($user->avatar);
                }
    
                // Subir nuevo avatar a Firebase
                $avatarUrl = $firebaseStorage->uploadAvatar($request->file('avatar'), $user->id);
                
                // Actualizar URL en la base de datos
                $user->avatar = $avatarUrl;
                $user->save();
    
                return redirect()->back()->with('success', 'Avatar actualizado correctamente');
            }
    
            return redirect()->back()->with('error', 'No se ha seleccionado ninguna imagen');
    
        } catch (\Exception $e) {
            Log::error('Error actualizando avatar: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al actualizar el avatar: ' . $e->getMessage());
        }
    }

    private function isJerseyNumberTaken($number, $excludeUser = null)
    {
        $query = PlayerProfile::where('jersey_number', $number);
        
        if ($excludeUser) {
            $query->where('user_id', '!=', $excludeUser->id);
        }

        return $query->exists();
    }
}