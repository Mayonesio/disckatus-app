@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Bienvenido, ' . Auth::user()->name)

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Miembros card -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Miembros</h2>
        <p class="text-4xl font-bold text-[#10163f]">{{ $totalMembers ?? 0 }}</p>
        <p class="text-sm text-gray-500">{{ $newMembersThisMonth ?? 0 }} nuevos este mes</p>
    </div>

    <!-- Torneos card -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Próximos Torneos</h2>
        <ul class="space-y-2">
            @if(isset($upcomingTournaments))
                @foreach($upcomingTournaments as $tournament)
                    <li class="flex justify-between items-center">
                        <span>{{ $tournament->name }}</span>
                        <span class="text-sm text-gray-500">{{ $tournament->date->format('d M') }}</span>
                    </li>
                @endforeach
            @else
                <li class="text-gray-500">No hay torneos próximos</li>
            @endif
        </ul>
    </div>

    <!-- Pagos card -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Estado de Pagos</h2>
        <div class="flex items-center justify-between">
            <div class="w-16 h-16 rounded-full border-4 border-[#ffd200] flex items-center justify-center">
                <span class="text-xl font-bold">{{ $paymentPercentage ?? 0 }}%</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Pagos al día</p>
                <p class="text-sm text-red-500">{{ $overduePayments ?? 0 }} morosos</p>
            </div>
        </div>
    </div>
</div>

<!-- Próximos entrenamientos -->
<div class="mt-8">
    <h2 class="text-xl font-semibold mb-4">Próximos Entrenamientos</h2>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="p-4 border rounded-lg">
                <h3 class="font-medium">Lunes</h3>
                <p class="text-gray-600">19:00 - 21:00</p>
                <p class="text-sm text-gray-500">Campo Municipal</p>
            </div>
            <div class="p-4 border rounded-lg">
                <h3 class="font-medium">Miércoles</h3>
                <p class="text-gray-600">19:00 - 21:00</p>
                <p class="text-sm text-gray-500">Campo Municipal</p>
            </div>
        </div>
    </div>
</div>
@endsection