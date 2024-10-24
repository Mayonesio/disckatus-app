@extends('layouts.app')

@section('title', 'Miembros')
@section('header', 'Miembros del Equipo')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Acciones superiores -->
        <div class=" bg-[#10163f] p-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <h1 class="text-2xl font-bold text-white">Miembros del Equipo</h1>
                <div class="flex space-x-4">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Buscar miembro..." 
                               class="pl-10 pr-4 py-2 rounded-full border-2 border-white bg-white bg-opacity-20 text-white placeholder-white focus:outline-none focus:border-[#ffd200] transition duration-300">
                        <div class="absolute left-3 top-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <select class="px-4 py-2 rounded-full border-2 border-white bg-white bg-opacity-20 text-blue focus:outline-none focus:border-[#ffd200] transition duration-300">
                        <option value="">Todos los roles</option>
                        <option value="captain">Capitán</option>
                        <option value="player">Jugador</option>
                    </select>
                    <button class="bg-white text-[#10163f] px-6 py-2 rounded-full hover:bg-[#ffd200] transition duration-300 transform hover:scale-105">
                        Invitar Jugador
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de miembros -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jugador
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Posición
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Número
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Experiencia
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr class="hover:bg-gray-50 transition duration-300">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($member->avatar)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $member->avatar }}" alt="">
                                    @else
                                        <div class="h-10 w-10 rounded-full bg-[#10163f] flex items-center justify-center text-white text-lg font-semibold">
                                            {{ substr($member->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $member->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $member->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $member->playerProfile?->position == 'handler' ? 'bg-blue-100 text-blue-800' : 
                                       ($member->playerProfile?->position == 'cutter' ? 'bg-green-100 text-green-800' : 
                                       'bg-gray-100 text-gray-800') }}">
                                    {{ $member->playerProfile?->position ?? 'No definida' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->playerProfile?->jersey_number ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="mr-2 w-16 bg-gray-200 rounded-full h-2">
                                        <div class="bg-[#ffd200] h-2 rounded-full" style="width: {{ min(($member->playerProfile?->experience_years ?? 0) * 10, 100) }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-500">{{ $member->playerProfile?->experience_years ?? '0' }} años</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $member->playerProfile?->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $member->playerProfile?->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('members.show', $member) }}" 
                                   class="text-[#10163f] hover:text-[#ffd200] mr-4 transition duration-300">
                                    Ver
                                </a>
                                @if(auth()->user()->id === $member->id || auth()->user()->hasRole('captain'))
                                    <a href="{{ route('members.edit', $member) }}" 
                                       class="text-[#10163f] hover:text-[#ffd200] transition duration-300">
                                        Editar
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No hay miembros registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Aquí puedes agregar JavaScript para mejorar la interactividad
    // Por ejemplo, para la búsqueda en tiempo real o filtrado dinámico
</script>
@endpush