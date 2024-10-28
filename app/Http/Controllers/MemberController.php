<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'special_throws' => 'nullable|array',
            'special_throws.*' => 'string|in:hammer,scoober,push_pass,thumber,low_release,high_release,espantaguiris,blade,no_look,over_the_head,upside_down',
            'throws_notes' => 'nullable|string',
            'hammer_rating' => 'nullable|integer|min:1|max:10',
            'scoober_rating' => 'nullable|integer|min:1|max:10',
            'push_pass_rating' => 'nullable|integer|min:1|max:10',
            'thumber_rating' => 'nullable|integer|min:1|max:10',
            'low_release_rating' => 'nullable|integer|min:1|max:10',
            'high_release_rating' => 'nullable|integer|min:1|max:10',
            'espantaguiris_rating' => 'nullable|integer|min:1|max:10',
            'blade_rating' => 'nullable|integer|min:1|max:10',
            'no_look_rating' => 'nullable|integer|min:1|max:10',
            'over_the_head_rating' => 'nullable|integer|min:1|max:10',
            'upside_down_rating' => 'nullable|integer|min:1|max:10',
        ]);

        try {
            DB::transaction(function () use ($user, $validated, $request) {
                // Datos básicos del perfil
                $profileData = collect($validated)->except([
                    'special_throws', 
                    'throws_notes',
                    'hammer_rating',
                    'scoober_rating',
                    'push_pass_rating',
                    'thumber_rating',
                    'low_release_rating',
                    'high_release_rating',
                    'espantaguiris_rating',
                    'blade_rating',
                    'no_look_rating',
                    'over_the_head_rating',
                    'upside_down_rating'
                ])->toArray();

                // Actualizar perfil básico
                $profile = $user->playerProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    $profileData
                );

                // Actualizar lanzamientos especiales
                $specialThrows = $request->input('special_throws', []);
                $profile->special_throws = $specialThrows;
                
                // Actualizar ratings de lanzamientos
                foreach ($specialThrows as $throw) {
                    $ratingKey = "{$throw}_rating";
                    if ($request->has($ratingKey)) {
                        $profile->{$ratingKey} = $request->input($ratingKey);
                    }
                }

                // Guardar notas de lanzamientos
                if ($request->has('throws_notes')) {
                    $profile->throws_notes = $request->input('throws_notes');
                }

                $profile->save();
            });

            return redirect()->route('members.show', $user)
                ->with('success', 'Perfil actualizado correctamente');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al actualizar el perfil. Por favor, inténtalo de nuevo.')
                ->withInput();
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