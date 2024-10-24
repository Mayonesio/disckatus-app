<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Jugador - {{ $user->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <main class="flex-1 p-8 overflow-y-auto">
            <div class="max-w-4xl mx-auto">
                <!-- Header con foto y nombre -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-[#10163f] to-[#ffd200] opacity-50"></div>
                    <div class="flex items-center space-x-4 relative z-10">
                        @if($user->avatar)
                            <img src="{{ $user->avatar }}" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
                        @else
                            <div class="w-24 h-24 rounded-full bg-[#10163f] flex items-center justify-center text-white text-3xl border-4 border-white shadow-lg">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#10163f] text-white">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        @if(auth()->user()->id === $user->id || auth()->user()->hasRole('captain'))
                            <a href="{{ route('members.edit', $user) }}" 
                               class="ml-auto bg-[#10163f] text-white px-4 py-2 rounded-lg hover:bg-[#ffd200] hover:text-[#10163f] transition duration-300 ease-in-out transform hover:scale-105">
                                Editar Perfil
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Información del jugador -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Detalles básicos -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Detalles del Jugador</h2>
                        <dl class="space-y-4">
                            <div class="flex items-center">
                                <dt class="text-sm font-medium text-gray-500 w-1/3">Posición</dt>
                                <dd class="mt-1 text-sm text-gray-900 w-2/3 bg-gray-100 rounded-full px-3 py-1">
                                    {{ $user->playerProfile?->position ?? 'No especificado' }}
                                </dd>
                            </div>
                            <div class="flex items-center">
                                <dt class="text-sm font-medium text-gray-500 w-1/3">Número de Dorsal</dt>
                                <dd class="mt-1 text-sm text-gray-900 w-2/3 bg-gray-100 rounded-full px-3 py-1">
                                    {{ $user->playerProfile?->jersey_number ?? 'No asignado' }}
                                </dd>
                            </div>
                            <div class="flex items-center">
                                <dt class="text-sm font-medium text-gray-500 w-1/3">Años de Experiencia</dt>
                                <dd class="mt-1 text-sm text-gray-900 w-2/3 bg-gray-100 rounded-full px-3 py-1">
                                    {{ $user->playerProfile?->experience_years ?? '0' }} años
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Estadísticas -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Estadísticas</h2>
                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Velocidad</dt>
                                <dd class="mt-1 flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-[#ffd200] h-2 rounded-full" 
                                             style="width: {{ ($user->playerProfile?->speed_rating ?? 0) * 10 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $user->playerProfile?->speed_rating ?? 0 }}/10
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Resistencia</dt>
                                <dd class="mt-1 flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-2 mr-2">
                                        <div class="bg-[#ffd200] h-2 rounded-full" 
                                             style="width: {{ ($user->playerProfile?->endurance_rating ?? 0) * 10 }}%">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-700">
                                        {{ $user->playerProfile?->endurance_rating ?? 0 }}/10
                                    </span>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Contacto de Emergencia -->
                    @if(auth()->user()->id === $user->id || auth()->user()->hasRole('captain'))
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Contacto de Emergencia</h2>
                        <dl class="space-y-4">
                            <div class="flex items-center">
                                <dt class="text-sm font-medium text-gray-500 w-1/3">Nombre</dt>
                                <dd class="mt-1 text-sm text-gray-900 w-2/3 bg-gray-100 rounded-full px-3 py-1">
                                    {{ $user->playerProfile?->emergency_contact ?? 'No especificado' }}
                                </dd>
                            </div>
                            <div class="flex items-center">
                                <dt class="text-sm font-medium text-gray-500 w-1/3">Teléfono</dt>
                                <dd class="mt-1 text-sm text-gray-900 w-2/3 bg-gray-100 rounded-full px-3 py-1">
                                    {{ $user->playerProfile?->emergency_phone ?? 'No especificado' }}
                                </dd>
                            </div>
                        </dl>
                    </div>
                    @endif

                    <!-- Participación en Torneos -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Participación en Torneos</h2>
                        @if($user->tournaments->count() > 0)
                            <ul class="space-y-2">
                                @foreach($user->tournaments->take(5) as $tournament)
                                    <li class="flex justify-between items-center bg-gray-100 rounded-lg p-2">
                                        <span class="font-medium">{{ $tournament->name }}</span>
                                        <span class="text-sm text-gray-600">{{ $tournament->date->format('d/m/Y') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            @if($user->tournaments->count() > 5)
                                <a href="#" class="text-[#10163f] hover:text-[#ffd200] mt-2 inline-block">Ver todos los torneos</a>
                            @endif
                        @else
                            <p class="text-gray-600">No ha participado en torneos aún.</p>
                        @endif
                    </div>
                </div>

                <!-- Gráfico de Rendimiento -->
                <div class="mt-6 bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Rendimiento en el Tiempo</h2>
                    <canvas id="performanceChart" width="400" height="200"></canvas>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Datos de ejemplo para el gráfico
        const ctx = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
                datasets: [{
                    label: 'Velocidad',
                    data: [5, 6, 7, 7, 8, 8],
                    borderColor: '#ffd200',
                    tension: 0.1
                }, {
                    label: 'Resistencia',
                    data: [4, 5, 5, 6, 7, 7],
                    borderColor: '#10163f',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10
                    }
                }
            }
        });
    </script>
</body>
</html>