@extends('layouts.app')

@section('title', 'Editar Perfil - ' . $user->name)
@section('header', 'Editar Perfil')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Formulario de Avatar -->
    <form action="{{ route('members.update-avatar', $user) }}" method="POST" enctype="multipart/form-data" class="mb-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Avatar</h2>
            <div class="flex items-center space-x-6">
                <!-- Avatar actual -->
                <div class="shrink-0">
                    @if($user->avatar)
                        <img src="{{ $user->avatar_url }}" alt="Avatar actual" class="h-16 w-16 object-cover rounded-full">
                    @else
                        <div class="h-16 w-16 rounded-full flex items-center justify-center text-white text-xl"
                            style="background-color: {{ $user->avatar_color ?? '#10163f' }}">
                            {{ $user->initials }}
                        </div>
                    @endif
                </div>

                <!-- Opciones de avatar -->
                <div class="flex-1">
                    <div class="space-y-4">
                        <!-- Subir imagen -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                Subir nueva imagen
                            </label>
                            <input type="file" name="avatar" accept="image/*" class="mt-1 block w-full text-sm text-gray-500
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-full file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-[#10163f] file:text-white
                                   hover:file:bg-[#ffd200] hover:file:text-[#10163f]">
                        </div>

                        <!-- Colores predefinidos -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                O elige un color
                            </label>
                            <div class="grid grid-cols-4 gap-2">
                                @php
                                    $colors = [
                                        '#4F46E5',
                                        '#10B981',
                                        '#F59E0B',
                                        '#EF4444',
                                        '#8B5CF6',
                                        '#EC4899',
                                        '#10163f',
                                        '#ffd200',
                                        '#14B8A6',
                                        '#F97316',
                                        '#06B6D4',
                                        '#6366F1'
                                    ];
                                @endphp

                                @foreach($colors as $index => $color)
                                    <button type="button"
                                        onclick="document.getElementById('avatar_color').value = '{{ $color }}'"
                                        class="w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#10163f]"
                                        style="background-color: {{ $color }}">
                                    </button>
                                @endforeach
                            </div>
                            <input type="hidden" name="avatar_color" id="avatar_color">
                        </div>

                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent 
                                shadow-sm text-sm font-medium rounded-md text-white bg-[#10163f] 
                                hover:bg-[#ffd200] hover:text-[#10163f]">
                            Actualizar Avatar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Formulario de Perfil (el resto del contenido) -->
    <form action="{{ route('members.update', $user) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <!-- ... resto del formulario ... -->
    </form>
</div>

@push('scripts')
    <script>
        document.getElementById('avatar').onchange = function (e) {
            const preview = document.getElementById('avatar-preview');
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function (e) {
                preview.querySelector('img').src = e.target.result;
                preview.classList.remove('hidden');
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        };
    </script>
@endpush
<!-- Información básica -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-semibold mb-6 text-[#10163f]">Editar Información del Jugador</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Posición -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Posición</label>
            <select name="position"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                <option value="">Seleccionar posición</option>
                <option value="handler" {{ $user->playerProfile?->position == 'handler' ? 'selected' : '' }}>
                    Handler</option>
                <option value="cutter" {{ $user->playerProfile?->position == 'cutter' ? 'selected' : '' }}>Cutter
                </option>
                <option value="both" {{ $user->playerProfile?->position == 'both' ? 'selected' : '' }}>Ambas
                </option>
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
                pattern="(?:(?:\+|00)?34)?[6789]\d{8}" placeholder="+34666555444"
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
                Velocidad: <span
                    id="speed_value">{{ old('speed_rating', $user->playerProfile?->speed_rating ?? 5) }}</span>/10
            </label>
            <input type="range" name="speed_rating" min="1" max="10"
                value="{{ old('speed_rating', $user->playerProfile?->speed_rating ?? 5) }}"
                class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                oninput="document.getElementById('speed_value').textContent = this.value">
        </div>

        <!-- Resistencia -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Resistencia: <span
                    id="endurance_value">{{ old('endurance_rating', $user->playerProfile?->endurance_rating ?? 5) }}</span>/10
            </label>
            <input type="range" name="endurance_rating" min="1" max="10"
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
        @foreach($specialThrows as $throw => $throwName)
            <div>
                <label for="{{ $throw }}_rating" class="block text-sm font-medium text-gray-700">{{ $throwName }}</label>
                <input type="number" id="{{ $throw }}_rating" name="{{ $throw }}_rating"
                    value="{{ old($throw . '_rating', $user->playerProfile?->{$throw . '_rating'}) }}" min="0" max="10"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
            </div>
        @endforeach
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
            checkbox.addEventListener('change', function () {
                const throwRating = this.closest('div').nextElementSibling;
                throwRating.classList.toggle('hidden', !this.checked);
            });
        });
    </script>
@endpush
@endsection