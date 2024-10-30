@extends('layouts.app')

@section('title', 'Perfil de ' . $user->name)
@section('header', $user->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header con foto y nombre -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-[#10163f] to-[#ffd200] opacity-50"></div>
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 relative z-10">
            <!-- Avatar -->
            @if($user->avatar)
                <img src="{{ $user->avatar }}" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-white shadow-lg">
            @else
                <div class="w-24 h-24 rounded-full bg-[#10163f] flex items-center justify-center text-white text-3xl border-4 border-white shadow-lg">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif

            <!-- Info del usuario -->
            <div class="flex-grow">
                <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                <p class="text-gray-600">{{ $user->email }}</p>
                <div class="mt-2 flex flex-wrap gap-2">
                    @if($user->roles)
                        @foreach($user->roles as $role)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#10163f] text-white">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Medallas -->
            <div class="flex flex-wrap gap-2">
                @foreach(json_decode($user->playerProfile?->special_throws ?? '[]', true) as $throw)
                    @php
                        $rating = $user->playerProfile->{$throw.'_rating'} ?? 0;
                        $color = $rating >= 8 ? '#FFD700' : ($rating >= 5 ? '#C0C0C0' : '#CD7F32');
                    @endphp
                    <div class="relative group">
                        <svg class="w-10 h-10" viewBox="0 0 24 24" fill="{{ $color }}" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.12v5.7c0 4.83-3.36 9.36-7 10.46-3.64-1.1-7-5.63-7-10.46v-5.7l7-3.12z"/>
                            <path fill="#10163f" d="M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                        </svg>
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs font-bold">
                            {{ substr(ucfirst($throw), 0, 1) }}
                        </span>
                        <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 bg-gray-800 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap">
                            {{ ucfirst(str_replace('_', ' ', $throw)) }}: {{ $rating }}/10
                        </div>
                    </div>
                @endforeach
            </div>

            @if(auth()->user()->id === $user->id || auth()->user()->hasRole('captain'))
                <a href="{{ route('members.edit', $user) }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#10163f] text-white rounded-lg hover:bg-[#ffd200] hover:text-[#10163f] transition duration-300">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Editar Perfil
                </a>
            @endif
        </div>
    </div>

    <!-- Información del jugador -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Detalles básicos -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Detalles del Jugador</h2>
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
            <h2 class="text-xl font-semibold mb-4">Estadísticas</h2>
            <dl class="space-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Velocidad</dt>
                    <dd class="mt-1">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#ffd200] h-2 rounded-full" 
                                 style="width: {{ ($user->playerProfile?->speed_rating ?? 0) * 10 }}%">
                            </div>
                        </div>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Resistencia</dt>
                    <dd class="mt-1">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-[#ffd200] h-2 rounded-full" 
                                 style="width: {{ ($user->playerProfile?->endurance_rating ?? 0) * 10 }}%">
                            </div>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Contacto de Emergencia -->
        @if(auth()->user()->id === $user->id || auth()->user()->hasRole('captain'))
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-4">Contacto de Emergencia</h2>
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
                        @if($user->playerProfile?->emergency_phone)
                            <a href="tel:{{ $user->playerProfile->emergency_phone }}" 
                               class="flex items-center space-x-2 hover:text-[#10163f]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>{{ $user->playerProfile->emergency_phone }}</span>
                            </a>
                        @else
                            <span>No especificado</span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
        @endif
    </div>

    <!-- Logros y Medallas -->
<div class="mt-6 bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold mb-4 text-[#10163f]">Logros y Medallas</h2>
    
    @if($user->playerProfile && count($user->playerProfile->getActiveThrows()) > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
            @foreach($user->playerProfile->getActiveThrows() as $throw)
                <div class="flex flex-col items-center space-y-2 p-4 bg-gray-50 rounded-lg">
                    <div class="relative">
                        <svg class="w-12 h-12" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path class="{{ $throw['level']->color() }}" 
                                  d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.12v5.7c0 4.83-3.36 9.36-7 10.46-3.64-1.1-7-5.63-7-10.46v-5.7l7-3.12z"/>
                        </svg>
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-white text-xs font-bold">
                            {{ $throw['level']->icon() }}
                        </span>
                    </div>
                    
                    <span class="text-sm font-medium text-gray-900 text-center">
                        {{ $throw['type']->label() }}
                    </span>
                    
                    <span class="text-xs px-2 py-1 rounded-full {{ $throw['level']->color() }}">
                        {{ $throw['level']->label() }}
                    </span>
                </div>
            @endforeach
        </div>

        @if($user->playerProfile->throws_notes)
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Observaciones</h3>
                <p class="text-sm text-gray-600">{{ $user->playerProfile->throws_notes }}</p>
            </div>
        @endif
    @else
        <p class="text-gray-500 text-center py-8">Este jugador aún no ha registrado sus lanzamientos especiales</p>
    @endif

    @if($user->id === Auth::id() || Auth::user()->isCaptain())
        <div class="mt-4 text-center">
            <a href="{{ route('members.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 bg-[#10163f] text-white rounded hover:bg-[#ffd200] hover:text-[#10163f]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Editar Lanzamientos
            </a>
        </div>
    @endif
</div>

    <!-- Gráfico de Rendimiento -->
    @if(isset($performanceData))
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold mb-4">Rendimiento en el Tiempo</h2>
        <canvas id="performanceChart" width="400" height="200"></canvas>
    </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($performanceData['labels'] ?? []) !!},
            datasets: [{
                label: 'Velocidad',
                data: {!! json_encode($performanceData['speed'] ?? []) !!},
                borderColor: '#ffd200',
                tension: 0.1
            }, {
                label: 'Resistencia',
                data: {!! json_encode($performanceData['endurance'] ?? []) !!},
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
@endpush
@endsection