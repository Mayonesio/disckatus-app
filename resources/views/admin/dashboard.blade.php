@extends('layouts.app')

@section('title', 'Panel de Administración')

@section('header')
<div class="flex items-center justify-between">
    <h1 class="text-2xl font-bold">Panel de Administración</h1>
    <a href="{{ route('dashboard') }}" 
       class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        Volver al Dashboard
    </a>
</div>
@endsection

@section('content')
<div class="space-y-6">
    <!-- Resumen -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Roles -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Roles</h3>
                <a href="{{ route('admin.roles.manage') }}" 
                   class="text-sm text-[#10163f] hover:text-[#ffd200]">
                    Gestionar
                </a>
            </div>
            <ul class="space-y-3">
                @foreach($roleStats as $role)
                    <li class="flex justify-between items-center">
                        <span class="text-gray-600">{{ $role->name }}</span>
                        <span class="px-2 py-1 bg-gray-100 rounded-full text-sm font-medium">
                            {{ $role->users_count }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Últimos Registros -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Últimos Registros</h3>
                <a href="{{ route('admin.users.index') }}" 
                   class="text-sm text-[#10163f] hover:text-[#ffd200]">
                    Ver todos
                </a>
            </div>
            <ul class="space-y-3">
                @foreach($recentUsers as $user)
                    <li class="flex items-center justify-between">
                        <div class="flex items-center">
                            @if($user->avatar)
                                <img src="{{ $user->avatar_url }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-8 h-8 rounded-full mr-2">
                            @else
                                <div class="w-8 h-8 rounded-full bg-[#10163f] text-white flex items-center justify-center mr-2">
                                    {{ $user->initials }}
                                </div>
                            @endif
                            <div>
                                <p class="text-sm font-medium">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500">
                            {{ $user->created_at->diffForHumans() }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium mb-4">Acciones Rápidas</h3>
            <div class="space-y-3">
                <a href="{{ route('members.create') }}" 
                   class="block w-full p-3 text-center bg-[#10163f] text-white rounded-lg 
                          hover:bg-[#ffd200] hover:text-[#10163f] transition-colors">
                    Crear Nuevo Miembro
                </a>
                <a href="{{ route('admin.roles.manage') }}" 
                   class="block w-full p-3 text-center bg-gray-100 text-gray-700 rounded-lg 
                          hover:bg-gray-200 transition-colors">
                    Gestionar Roles
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="block w-full p-3 text-center bg-gray-100 text-gray-700 rounded-lg 
                          hover:bg-gray-200 transition-colors">
                    Ver Usuarios
                </a>
            </div>
        </div>
    </div>

    <!-- Gestión de Usuarios -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-lg font-medium">Gestión de Usuarios</h2>
            <div class="flex space-x-2">
                <input type="text" 
                       placeholder="Buscar usuario..." 
                       class="px-4 py-2 border rounded-lg focus:outline-none focus:border-[#10163f]">
                <button class="px-4 py-2 bg-[#10163f] text-white rounded-lg hover:bg-[#ffd200] hover:text-[#10163f]">
                    Buscar
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Usuario
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Roles
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($user->avatar)
                                        <img src="{{ $user->avatar_url }}" 
                                             alt="{{ $user->name }}"
                                             class="w-10 h-10 rounded-full">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-[#10163f] flex items-center justify-center text-white">
                                            {{ $user->initials }}
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            Miembro desde {{ $user->created_at->format('M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                   {{ $role->slug === 'super-admin' ? 'bg-purple-100 text-purple-800' :
                                                      ($role->slug === 'captain' ? 'bg-blue-100 text-blue-800' :
                                                      ($role->slug === 'sotg-captain' ? 'bg-green-100 text-green-800' :
                                                       'bg-gray-100 text-gray-800')) }}">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->playerProfile?->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-3">
                                    <button onclick="openRoleModal('{{ $user->id }}')"
                                            class="text-[#10163f] hover:text-[#ffd200]">
                                        Cambiar Rol
                                    </button>
                                    <a href="{{ route('members.edit', $user) }}" 
                                       class="text-[#10163f] hover:text-[#ffd200]">
                                        Editar
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Modal para editar roles -->
<div id="roleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Roles</h3>
            <form id="roleForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mt-2 space-y-3">
                    @foreach($allRoles as $role)
                        <div class="flex items-center">
                            <input type="checkbox" 
                                   name="roles[]" 
                                   value="{{ $role->id }}"
                                   class="h-4 w-4 text-[#10163f] border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="document.getElementById('roleModal').classList.add('hidden')"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-[#10163f] text-white rounded-md hover:bg-[#ffd200] hover:text-[#10163f]">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function openRoleModal(userId) {
    const modal = document.getElementById('roleModal');
    const form = document.getElementById('roleForm');
    
    // Limpiar checkboxes anteriores
    form.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Obtener roles actuales del usuario
    fetch(`/admin/users/${userId}/roles`)
        .then(response => response.json())
        .then(data => {
            data.roles.forEach(roleId => {
                const checkbox = form.querySelector(`input[value="${roleId}"]`);
                if (checkbox) checkbox.checked = true;
            });
        });
    
    // Actualizar action del formulario
    form.action = `/admin/users/${userId}/roles`;
    
    // Mostrar modal
    modal.classList.remove('hidden');
}

// Cerrar modal con Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.getElementById('roleModal').classList.add('hidden');
    }
});
</script>
@endpush
@endsection