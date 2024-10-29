<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        
        $specialThrows = [
            'hammer' => 'Hammer',
            'scoober' => 'Scoober',
            'push_pass' => 'Push Pass',
            'thumber' => 'Thumber',
            'low_release' => 'Low Release',
            'high_release' => 'High Release',
            'espantaguiris' => 'Espantaguiris',
            'blade' => 'Blade',
            'no_look' => 'No Look',
            'over_the_head' => 'Over the Head',
            'upside_down' => 'Upside Down'
        ];
        
        // Datos de ejemplo para el gráfico de rendimiento
        $performanceData = [
            'labels' => ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
            'speed' => [5, 6, 7, 7, 8, 8],
            'endurance' => [4, 5, 5, 6, 7, 7]
        ];
    
        return view('members.show', compact('user', 'performanceData', 'specialThrows'));
    }
    public function edit(User $user)
    {
        $user->load(['playerProfile', 'roles']);
        $specialThrows = [
            'hammer' => 'Hammer',
            'scoober' => 'Scoober',
            'push_pass' => 'Push Pass',
            'thumber' => 'Thumber',
            'low_release' => 'Low Release',
            'high_release' => 'High Release',
            'espantaguiris' => 'Espantaguiris',
            'blade' => 'Blade',
            'no_look' => 'No Look',
            'over_the_head' => 'Over the Head',
            'upside_down' => 'Upside Down'
        ];
        return view('members.edit', compact('user', 'specialThrows'));
    }

    // public function update(Request $request, User $user)
    // {
    //     Log::info('Iniciando actualización de perfil', ['user_id' => $user->id]);

    //     $validated = $request->validate([
    //         'position' => 'nullable|string|in:handler,cutter,both',
    //         'jersey_number' => [
    //             'nullable',
    //             'integer',
    //             'min:0',
    //             'max:99',
    //             function ($attribute, $value, $fail) use ($user) {
    //                 if ($this->isJerseyNumberTaken($value, $user)) {
    //                     $fail('Este número de dorsal ya está en uso.');
    //                 }
    //             },
    //         ],
    //         'experience_years' => 'nullable|integer|min:0',
    //         'speed_rating' => 'nullable|integer|min:1|max:10',
    //         'endurance_rating' => 'nullable|integer|min:1|max:10',
    //         'emergency_contact' => 'nullable|string|max:255',
    //         'emergency_phone' => 'nullable|string|max:20',
    //         'special_throws' => 'nullable|array',
    //         'special_throws.*' => 'string|in:hammer,scoober,push_pass,thumber,low_release,high_release,espantaguiris,blade,no_look,over_the_head,upside_down',
    //         'throws_notes' => 'nullable|string',
    //         'hammer_rating' => 'nullable|integer|min:1|max:10',
    //         'scoober_rating' => 'nullable|integer|min:1|max:10',
    //         'push_pass_rating' => 'nullable|integer|min:1|max:10',
    //         'thumber_rating' => 'nullable|integer|min:1|max:10',
    //         'low_release_rating' => 'nullable|integer|min:1|max:10',
    //         'high_release_rating' => 'nullable|integer|min:1|max:10',
    //         'espantaguiris_rating' => 'nullable|integer|min:1|max:10',
    //         'blade_rating' => 'nullable|integer|min:1|max:10',
    //         'no_look_rating' => 'nullable|integer|min:1|max:10',
    //         'over_the_head_rating' => 'nullable|integer|min:1|max:10',
    //         'upside_down_rating' => 'nullable|integer|min:1|max:10',
    //         'avatar_preset' => 'nullable|string|starts_with:avatar-',
    //         'avatar_image' => 'nullable|image|max:2048',
    //     ]);

    //     try {
    //         DB::transaction(function () use ($user, $validated, $request) {
    //             Log::info('Iniciando transacción DB');

    //             // Manejar avatar
    //             if ($request->hasFile('avatar_image')) {
    //                 $path = $request->file('avatar_image')->store('avatars', 'public');
    //                 $user->avatar = Storage::url($path);
    //                 $user->save();
    //             } elseif ($request->has('avatar_preset')) {
    //                 $preset = $request->input('avatar_preset');
    //                 $index = str_replace('avatar-', '', $preset);
    //                 $colors = [
    //                     '#4F46E5', '#10B981', '#F59E0B', '#EF4444', 
    //                     '#8B5CF6', '#EC4899', '#10163f', '#ffd200',
    //                     '#14B8A6', '#F97316', '#06B6D4', '#6366F1'
    //                 ];
    //                 $user->avatar_color = $colors[$index - 1];
    //                 $user->save();
    //             }

    //             // Datos básicos del perfil
    //             $profileData = collect($validated)->except([
    //                 'special_throws', 
    //                 'throws_notes',
    //                 'hammer_rating',
    //                 'scoober_rating',
    //                 'push_pass_rating',
    //                 'thumber_rating',
    //                 'low_release_rating',
    //                 'high_release_rating',
    //                 'espantaguiris_rating',
    //                 'blade_rating',
    //                 'no_look_rating',
    //                 'over_the_head_rating',
    //                 'upside_down_rating',
    //                 'avatar_preset',
    //                 'avatar_image'
    //             ])->toArray();

    //             // Actualizar perfil básico
    //             $profile = $user->playerProfile()->updateOrCreate(
    //                 ['user_id' => $user->id],
    //                 $profileData
    //             );

    //             Log::info('Perfil básico actualizado', $profileData);

    //             // Actualizar lanzamientos especiales
    //             $specialThrows = [
    //                 'hammer', 'scoober', 'push_pass', 'thumber', 'low_release', 'high_release',
    //                 'espantaguiris', 'blade', 'no_look', 'over_the_head', 'upside_down'
    //             ];
    
    //             $userSpecialThrows = [];
    //             foreach ($specialThrows as $throw) {
    //                 $ratingKey = "{$throw}_rating";
    //                 if (isset($validated[$ratingKey]) && $validated[$ratingKey] > 0) {
    //                     $userSpecialThrows[] = $throw;
    //                     $profile->{$ratingKey} = $validated[$ratingKey];
    //                 } else {
    //                     $profile->{$ratingKey} = null;
    //                 }
    //             }
    
    //             $profile->special_throws = $userSpecialThrows;
    //             $profile->save();
    
    //             Log::info('Perfil guardado completamente');
    //         });

    //         return redirect()->route('members.show', $user)->with('success', 'Perfil actualizado correctamente');

    //     } catch (\Exception $e) {
    //         Log::error('Error en actualización de perfil', [
    //             'error' => $e->getMessage(),
    //             'trace' => $e->getTraceAsString()
    //         ]);

    //         return back()
    //             ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
    //             ->withInput();
    //     }

    // }

    public function update(Request $request, User $user)
    {
        Log::info('Iniciando actualización de perfil', ['user_id' => $user->id]);

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
            'avatar_preset' => 'nullable|string|starts_with:avatar-',
            'avatar_image' => 'nullable|image|max:2048',
        ]);

        try {
            DB::transaction(function () use ($user, $validated, $request) {
                Log::info('Iniciando transacción DB');

                // Manejar avatar
                if ($request->hasFile('avatar_image')) {
                    $path = $request->file('avatar_image')->store('avatars', 'public');
                    $user->avatar = Storage::url($path);
                    $user->save();
                } elseif ($request->has('avatar_preset')) {
                    $preset = $request->input('avatar_preset');
                    $index = str_replace('avatar-', '', $preset);
                    $colors = [
                        '#4F46E5', '#10B981', '#F59E0B', '#EF4444', 
                        '#8B5CF6', '#EC4899', '#10163f', '#ffd200',
                        '#14B8A6', '#F97316', '#06B6D4', '#6366F1'
                    ];
                    $user->avatar_color = $colors[$index - 1];
                    $user->save();
                }

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
                    'upside_down_rating',
                    'avatar_preset',
                    'avatar_image'
                ])->toArray();

                // Actualizar perfil básico
                $profile = $user->playerProfile()->updateOrCreate(
                    ['user_id' => $user->id],
                    $profileData
                );

                Log::info('Perfil básico actualizado', $profileData);

                // Actualizar lanzamientos especiales
                $specialThrows = [
                    'hammer', 'scoober', 'push_pass', 'thumber', 'low_release', 'high_release',
                    'espantaguiris', 'blade', 'no_look', 'over_the_head', 'upside_down'
                ];
    
                $userSpecialThrows = [];
                foreach ($specialThrows as $throw) {
                    $ratingKey = "{$throw}_rating";
                    if (isset($validated[$ratingKey]) && $validated[$ratingKey] > 0) {
                        $userSpecialThrows[] = $throw;
                        $profile->{$ratingKey} = $validated[$ratingKey];
                    } else {
                        $profile->{$ratingKey} = null;
                    }
                }
    
                $profile->special_throws = $userSpecialThrows;
                $profile->save();
    
                Log::info('Perfil guardado completamente');
            });

            return redirect()->route('members.show', $user)->with('success', 'Perfil actualizado correctamente');

        } catch (\Exception $e) {
            Log::error('Error en actualización de perfil', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'Error al actualizar el perfil: ' . $e->getMessage())
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