@extends('layouts.app')

@section('title', 'Editar Perfil - ' . $user->name)
@section('header', 'Editar Perfil')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('members.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Información básica -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-6 text-[#10163f]">Editar Información del Jugador</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Posición -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Posición</label>
                    <select name="position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                        <option value="">Seleccionar posición</option>
                        <option value="handler" {{ $user->playerProfile?->position == 'handler' ? 'selected' : '' }}>Handler</option>
                        <option value="cutter" {{ $user->playerProfile?->position == 'cutter' ? 'selected' : '' }}>Cutter</option>
                        <option value="both" {{ $user->playerProfile?->position == 'both' ? 'selected' : '' }}>Ambas</option>
                    </select>
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Dorsal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Dorsal</label>
                    <input type="number" name="jersey_number" min="0" max="99"
                           value="{{ old('jersey_number', $user->playerProfile?->jersey_number) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('jersey_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Años de Experiencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Años de Experiencia</label>
                    <input type="number" name="experience_years" min="0"
                           value="{{ old('experience_years', $user->playerProfile?->experience_years) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('experience_years')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contacto de Emergencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Contacto de Emergencia
                    </label>
                    <input type="text" name="emergency_contact"
                           value="{{ old('emergency_contact', $user->playerProfile?->emergency_contact) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('emergency_contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono de Emergencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfono de Emergencia
                        <span class="text-xs text-gray-500">(Formato: +34XXXXXXXXX)</span>
                    </label>
                    <input type="tel" name="emergency_phone"
                           value="{{ old('emergency_phone', $user->playerProfile?->emergency_phone) }}"
                           pattern="(?:(?:\+|00)?34)?[6789]\d{8}"
                           placeholder="+34666555444"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('emergency_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Estadísticas</h2>
            
            <div class="space-y-6">
                <!-- Velocidad -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Velocidad: <span id="speed_value">{{ old('speed_rating', $user->playerProfile?->speed_rating ?? 5) }}</span>/10
                    </label>
                    <input type="range" name="speed_rating" 
                           min="1" max="10" 
                           value="{{ old('speed_rating', $user->playerProfile?->speed_rating ?? 5) }}"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                           oninput="document.getElementById('speed_value').textContent = this.value">
                </div>

                <!-- Resistencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Resistencia: <span id="endurance_value">{{ old('endurance_rating', $user->playerProfile?->endurance_rating ?? 5) }}</span>/10
                    </label>
                    <input type="range" name="endurance_rating" 
                           min="1" max="10" 
                           value="{{ old('endurance_rating', $user->playerProfile?->endurance_rating ?? 5) }}"
                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                           oninput="document.getElementById('endurance_value').textContent = this.value">
                </div>
            </div>
        </div>

        <!-- Lanzamientos Especiales -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Lanzamientos Especiales</h2>
            
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                @php
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
                
                $userThrows = json_decode($user->playerProfile?->special_throws ?? '[]', true) ?: [];
                @endphp

                @foreach($specialThrows as $value => $label)
                <div class="space-y-2">
                    <div class="relative flex items-center">
                        <input type="checkbox" 
                               name="special_throws[]" 
                               id="throw_{{ $value }}" 
                               value="{{ $value }}"
                               {{ in_array($value, $userThrows) ? 'checked' : '' }}
                               class="h-4 w-4 text-[#10163f] border-gray-300 rounded focus:ring-[#ffd200]">
                        <label for="throw_{{ $value }}" class="ml-2 block text-sm text-gray-900">
                            {{ $label }}
                        </label>
                    </div>
                    
                    <div class="throw-rating {{ !in_array($value, $userThrows) ? 'hidden' : '' }}" data-throw="{{ $value }}">
                        <input type="range" 
                               name="{{ $value }}_rating" 
                               min="1" max="10" 
                               value="{{ old($value.'_rating', $user->playerProfile?->{$value.'_rating'} ?? 5) }}"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                               oninput="document.getElementById('{{ $value }}_value').textContent = this.value">
                        <span id="{{ $value }}_value" class="text-xs text-gray-500">
                            {{ old($value.'_rating', $user->playerProfile?->{$value.'_rating'} ?? 5) }}/10
                        </span>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Observaciones sobre lanzamientos -->
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Observaciones sobre lanzamientos</label>
                <textarea name="throws_notes" 
                          rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]"
                          placeholder="Añade comentarios sobre tus lanzamientos especiales...">{{ old('throws_notes', $user->playerProfile?->throws_notes) }}</textarea>
            </div>
        </div>

        <!-- Botones -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('members.show', $user) }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-4 py-2 bg-[#10163f] text-white rounded-lg hover:bg-[#ffd200] hover:text-[#10163f] transition-colors">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Gestionar visibilidad de los ratings de lanzamientos
document.querySelectorAll('input[name="special_throws[]"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const throwRating = this.closest('div').nextElementSibling;
        throwRating.classList.toggle('hidden', !this.checked);
    });
});
</script>
@endpush
@endsection