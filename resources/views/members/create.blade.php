@extends('layouts.app')

@section('title', 'Crear Nuevo Miembro')
@section('header', 'Crear Nuevo Miembro')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('members.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-semibold mb-6 text-[#10163f]">Información del Jugador</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Posición -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Posición</label>
                    <select name="position"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                        <option value="">Seleccionar posición</option>
                        <option value="handler" {{ old('position') == 'handler' ? 'selected' : '' }}>Handler</option>
                        <option value="cutter" {{ old('position') == 'cutter' ? 'selected' : '' }}>Cutter</option>
                        <option value="both" {{ old('position') == 'both' ? 'selected' : '' }}>Ambas</option>
                    </select>
                    @error('position')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Número de Dorsal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Número de Dorsal</label>
                    <input type="number" name="jersey_number" value="{{ old('jersey_number') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('jersey_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Años de Experiencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Años de Experiencia</label>
                    <input type="number" name="experience_years" value="{{ old('experience_years') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('experience_years')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Teléfono de Emergencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Teléfono de Emergencia
                        <span class="text-xs text-gray-500">(Formato: +34XXXXXXXXX)</span>
                    </label>
                    <input type="tel" name="emergency_phone" value="{{ old('emergency_phone') }}"
                        pattern="(?:(?:\+|00)?34)?[6789]\d{8}" placeholder="+34666555444"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                    @error('emergency_phone')
                        <p class="mt-1 text-sm text-red-600">El número de teléfono debe ser un número español válido</p>
                    @enderror
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Estadísticas del Jugador</h3>

                <!-- Velocidad -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Velocidad: <span id="speed_value">5</span>/10
                    </label>
                    <div class="flex items-center">
                        <input type="range" name="speed_rating" min="1" max="10" value="5"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                            oninput="document.getElementById('speed_value').textContent = this.value">
                    </div>
                    @error('speed_rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resistencia -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Resistencia: <span id="endurance_value">5</span>/10
                    </label>
                    <div class="flex items-center">
                        <input type="range" name="endurance_rating" min="1" max="10" value="5"
                            class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                            oninput="document.getElementById('endurance_value').textContent = this.value">
                    </div>
                    @error('endurance_rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Lanzamientos Especiales -->
            <div class="mt-6">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Lanzamientos Especiales</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
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
                    @endphp

                    @foreach($specialThrows as $value => $label)
                    <div class="relative flex items-center">
                        <input type="checkbox" 
                               name="special_throws[]" 
                               id="throw_{{ $value }}" 
                               value="{{ $value }}"
                               class="h-4 w-4 text-[#10163f] border-gray-300 rounded focus:ring-[#ffd200]">
                        <label for="throw_{{ $value }}" class="ml-2 block text-sm text-gray-900">
                            {{ $label }}
                        </label>
                    </div>
                    @endforeach
                </div>

                <!-- Nivel de dominio por lanzamiento -->
                <div class="mt-6 space-y-4">
                    <h5 class="text-md font-medium text-gray-700">Nivel de dominio</h5>
                    @foreach($specialThrows as $value => $label)
                    <div class="throw-rating hidden" data-throw="{{ $value }}">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            {{ $label }}: <span id="{{ $value }}_value">5</span>/10
                        </label>
                        <input type="range" 
                               name="{{ $value }}_rating" 
                               min="1" max="10" 
                               value="5"
                               class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                               oninput="document.getElementById('{{ $value }}_value').textContent = this.value">
                    </div>
                    @endforeach
                </div>

                <!-- Observaciones sobre lanzamientos -->
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Observaciones sobre lanzamientos</label>
                    <textarea name="throws_notes" 
                              rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]"
                              placeholder="Añade comentarios sobre tus lanzamientos especiales...">{{ old('throws_notes') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('members.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-300">
                    Cancelar
                </a>
                <button type="submit"
                    class="bg-[#10163f] text-white px-4 py-2 rounded-lg hover:bg-[#ffd200] hover:text-[#10163f] transition duration-300">
                    Crear Miembro
                </button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Script para actualizar los valores de los sliders en tiempo real
    document.querySelectorAll('input[type="range"]').forEach(function (slider) {
        slider.addEventListener('input', function () {
            document.getElementById(this.name + '_value').textContent = this.value;
        });
    });

    // Script para mostrar/ocultar niveles de dominio de lanzamientos
    document.querySelectorAll('input[name="special_throws[]"]').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const throwRating = document.querySelector(`.throw-rating[data-throw="${this.value}"]`);
            if (this.checked) {
                throwRating.classList.remove('hidden');
            } else {
                throwRating.classList.add('hidden');
            }
        });
    });
</script>
@endpush