@extends('layouts.app')

@section('title', 'Editar Perfil - ' . $user->name)
@section('header', 'Editar Perfil')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Formulario de Avatar -->
    <form action="{{ route('members.update-avatar', $user) }}" 
          method="POST" 
          enctype="multipart/form-data" 
          class="mb-6">
        @csrf
        <!-- @method('PUT') -->
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Avatar</h2>
            
            <div class="flex flex-col sm:flex-row items-center gap-6">
                <!-- Avatar actual -->
                <div class="shrink-0 relative group">
                    @if($user->avatar)
                        <img src="{{ $user->avatar_url }}" 
                             alt="Avatar actual" 
                             class="h-24 w-24 object-cover rounded-full border-2 border-[#10163f]">
                        @if(filter_var($user->avatar, FILTER_VALIDATE_URL))
                            <span class="absolute -bottom-2 left-0 right-0 text-xs text-center text-gray-500">
                                Avatar de Google
                            </span>
                        @endif
                    @elseif($user->avatar_color)
                        <div class="h-24 w-24 rounded-full flex items-center justify-center text-white text-3xl"
                             style="background-color: {{ $user->avatar_color }}">
                            {{ $user->initials }}
                        </div>
                    @else
                        <div class="h-24 w-24 rounded-full bg-[#10163f] flex items-center justify-center text-white text-3xl">
                            {{ $user->initials }}
                        </div>
                    @endif
                </div>

                <!-- Opciones de avatar -->
                <div class="flex-1 space-y-4">
                    <!-- Acciones para avatar existente -->
                    @if($user->avatar)
                        <div class="flex justify-start">
                            <button type="submit" 
                                    name="remove_avatar" 
                                    value="1"
                                    class="text-sm text-red-600 hover:text-red-800">
                                Eliminar avatar actual
                            </button>
                        </div>
                    @endif

                    <!-- Subir nueva imagen -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Subir nueva imagen
                        </label>
                        <input type="file" 
                               name="avatar" 
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-[#10163f] file:text-white
                                      hover:file:bg-[#ffd200] hover:file:text-[#10163f]
                                      focus:outline-none">
                    </div>

                    <!-- Vista previa -->
                    <div id="avatar-preview" class="hidden mt-2">
                        <img src="" alt="Preview" class="h-24 w-24 object-cover rounded-full border-2 border-[#10163f]">
                    </div>

                    <!-- Botón actualizar -->
                    <button type="submit" 
                            class="w-full sm:w-auto px-4 py-2 bg-[#10163f] text-white rounded-lg
                                   hover:bg-[#ffd200] hover:text-[#10163f] transition-colors
                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#10163f]">
                        Actualizar Avatar
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Formulario Principal -->
    <form action="{{ route('members.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Información básica -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 text-[#10163f]">Información del Jugador</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Posición -->
                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700">Posición</label>
                    <select id="position" 
                            name="position" 
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                   focus:border-[#10163f] focus:ring focus:ring-[#10163f] focus:ring-opacity-50">
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
                    <label for="jersey_number" class="block text-sm font-medium text-gray-700">Número de Dorsal</label>
                    <input type="number" 
                           id="jersey_number"
                           name="jersey_number" 
                           value="{{ old('jersey_number', $user->playerProfile?->jersey_number) }}"
                           min="0" 
                           max="99"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-[#10163f] focus:ring focus:ring-[#10163f] focus:ring-opacity-50">
                    @error('jersey_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Años de Experiencia -->
                <div>
                    <label for="experience_years" class="block text-sm font-medium text-gray-700">Años de Experiencia</label>
                    <input type="number" 
                           id="experience_years"
                           name="experience_years" 
                           value="{{ old('experience_years', $user->playerProfile?->experience_years) }}"
                           min="0"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-[#10163f] focus:ring focus:ring-[#10163f] focus:ring-opacity-50">
                    @error('experience_years')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contacto de Emergencia -->
                <div>
                    <label for="emergency_contact" class="block text-sm font-medium text-gray-700">Contacto de Emergencia</label>
                    <input type="text" 
                           id="emergency_contact"
                           name="emergency_contact"
                           value="{{ old('emergency_contact', $user->playerProfile?->emergency_contact) }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-[#10163f] focus:ring focus:ring-[#10163f] focus:ring-opacity-50">
                    @error('emergency_contact')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono de Emergencia -->
                <div class="col-span-2 md:col-span-1">
                    <label for="emergency_phone" class="block text-sm font-medium text-gray-700">
                        Teléfono de Emergencia
                        <span class="text-xs text-gray-500">(Formato: +34XXXXXXXXX)</span>
                    </label>
                    <input type="tel" 
                           id="emergency_phone"
                           name="emergency_phone"
                           value="{{ old('emergency_phone', $user->playerProfile?->emergency_phone) }}"
                           pattern="(?:(?:\+|00)?34)?[6789]\d{8}"
                           placeholder="+34666555444"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                  focus:border-[#10163f] focus:ring focus:ring-[#10163f] focus:ring-opacity-50">
                    @error('emergency_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Estadísticas -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 text-[#10163f]">Estadísticas</h2>
            
            <div class="space-y-6">
                <!-- Velocidad -->
                <div>
                    <label class="flex justify-between text-sm font-medium text-gray-700">
                        <span>Velocidad</span>
                        <span id="speed_value">{{ old('speed_rating', $user->playerProfile?->speed_rating ?? 5) }}/10</span>
                    </label>
                    <input type="range" 
                           name="speed_rating" 
                           min="1" 
                           max="10" 
                           value="{{ old('speed_rating', $user->playerProfile?->speed_rating ?? 5) }}"
                           class="mt-2 w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer
                                  accent-[#10163f]"
                           oninput="document.getElementById('speed_value').textContent = this.value + '/10'">
                </div>

                <!-- Resistencia -->
                <div>
                    <label class="flex justify-between text-sm font-medium text-gray-700">
                        <span>Resistencia</span>
                        <span id="endurance_value">{{ old('endurance_rating', $user->playerProfile?->endurance_rating ?? 5) }}/10</span>
                    </label>
                    <input type="range" 
                           name="endurance_rating" 
                           min="1" 
                           max="10" 
                           value="{{ old('endurance_rating', $user->playerProfile?->endurance_rating ?? 5) }}"
                           class="mt-2 w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer
                                  accent-[#10163f]"
                           oninput="document.getElementById('endurance_value').textContent = this.value + '/10'">
                </div>
            </div>
        </div>

        <!-- Lanzamientos Especiales -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Lanzamientos Especiales</h2>
            <p class="text-sm text-gray-600 mb-6">Selecciona tu nivel de dominio para cada lanzamiento. Los lanzamientos marcados como "No domino" no aparecerán en tu perfil.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach(\App\Enums\ThrowType::cases() as $throwType)
                    <div class="p-4 border rounded-lg hover:border-[#10163f] transition-colors duration-200">
                        <div class="mb-2">
                            <h3 class="font-medium text-gray-900">{{ $throwType->label() }}</h3>
                            <p class="text-sm text-gray-500">{{ $throwType->description() }}</p>
                        </div>

                        <div class="space-y-2 mt-3">
                            @foreach(\App\Enums\ThrowLevel::cases() as $level)
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="radio" 
                                           name="throw_levels[{{ $throwType->value }}]" 
                                           value="{{ $level->value }}"
                                           @checked($user->playerProfile?->getThrowLevel($throwType) === $level)
                                           class="w-4 h-4 text-[#10163f] border-gray-300 focus:ring-[#10163f]">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full {{ $level->color() }}">
                                        <span class="text-xs font-semibold">
                                            {{ $level->icon() }} {{ $level->label() }}
                                        </span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Observaciones sobre lanzamientos -->
            <div class="mt-6">
                <label for="throws_notes" class="block text-sm font-medium text-gray-700">
                    Observaciones sobre lanzamientos
                </label>
                <textarea id="throws_notes"
                          name="throws_notes" 
                          rows="3" 
                          class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm 
                                 focus:border-[#10163f] focus:ring focus:ring-[#10163f] focus:ring-opacity-50"
                          placeholder="Añade comentarios sobre tus lanzamientos especiales...">{{ old('throws_notes', $user->playerProfile?->throws_notes) }}</textarea>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('members.show', $user) }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg 
                      hover:bg-gray-300 transition-colors
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
            checkbox.addEventListener('change', function () {
                const throwRating = this.closest('div').nextElementSibling;
                throwRating.classList.toggle('hidden', !this.checked);
            });
        });
    </script>
@endpush
@endsection