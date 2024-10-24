<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil - {{ $user->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <form action="{{ route('members.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

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
                            </div>

                            <!-- Número de Dorsal -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Número de Dorsal</label>
                                <input type="number" name="jersey_number" value="{{ $user->playerProfile?->jersey_number }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                            </div>

                            <!-- Años de Experiencia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Años de Experiencia</label>
                                <input type="number" name="experience_years" value="{{ $user->playerProfile?->experience_years }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f]   focus:ring-[#10163f]">
                            </div>

                            <!-- Contacto de Emergencia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Contacto de Emergencia</label>
                                <input type="text" name="emergency_contact" value="{{ $user->playerProfile?->emergency_contact }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                            </div>

                            <!-- Teléfono de Emergencia -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono de Emergencia</label>
                                <input type="text" name="emergency_phone" value="{{ $user->playerProfile?->emergency_phone }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#10163f] focus:ring-[#10163f]">
                            </div>
                        </div>

                        <!-- Estadísticas -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Estadísticas del Jugador</h3>
                            
                            <!-- Velocidad -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Velocidad</label>
                                <div class="flex items-center">
                                    <input type="range" name="speed_rating" min="1" max="10" value="{{ $user->playerProfile?->speed_rating ?? 5 }}"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                           oninput="this.nextElementSibling.value = this.value">
                                    <output class="ml-2 text-gray-700">{{ $user->playerProfile?->speed_rating ?? 5 }}</output>
                                </div>
                            </div>

                            <!-- Resistencia -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Resistencia</label>
                                <div class="flex items-center">
                                    <input type="range" name="endurance_rating" min="1" max="10" value="{{ $user->playerProfile?->endurance_rating ?? 5 }}"
                                           class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer"
                                           oninput="this.nextElementSibling.value = this.value">
                                    <output class="ml-2 text-gray-700">{{ $user->playerProfile?->endurance_rating ?? 5 }}</output>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('members.show', $user) }}" 
                               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition duration-300">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-[#10163f] text-white px-4 py-2 rounded-lg hover:bg-[#ffd200] hover:text-[#10163f] transition duration-300">
                                Guardar Cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Script para actualizar los valores de los sliders en tiempo real
        document.querySelectorAll('input[type="range"]').forEach(function(slider) {
            slider.addEventListener('input', function() {
                this.nextElementSibling.value = this.value;
            });
        });
    </script>
</body>
</html>