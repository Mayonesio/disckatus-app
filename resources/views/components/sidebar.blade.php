<aside class="w-64 bg-[#10163f] text-white">
    <div class="p-4">
        <h1 class="text-2xl font-bold text-[#ffd200] mb-4">Disckatus</h1>
        <nav>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center p-2 {{ request()->routeIs('dashboard') ? 'bg-[#ffd200] text-[#10163f]' : 'hover:bg-[#ffd200] hover:text-[#10163f]' }} rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('members.index') }}" 
                       class="flex items-center p-2 {{ request()->routeIs('members.*') ? 'bg-[#ffd200] text-[#10163f]' : 'hover:bg-[#ffd200] hover:text-[#10163f]' }} rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Miembros
                    </a>
                </li>
                <li>
                    <a href="{{ route('tournaments') }}" 
                       class="flex items-center p-2 {{ request()->routeIs('tournaments') ? 'bg-[#ffd200] text-[#10163f]' : 'hover:bg-[#ffd200] hover:text-[#10163f]' }} rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Torneos
                    </a>
                </li>
                <li>
                    <a href="{{ route('payments') }}" 
                       class="flex items-center p-2 {{ request()->routeIs('payments') ? 'bg-[#ffd200] text-[#10163f]' : 'hover:bg-[#ffd200] hover:text-[#10163f]' }} rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Pagos
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings') }}" 
                       class="flex items-center p-2 {{ request()->routeIs('settings') ? 'bg-[#ffd200] text-[#10163f]' : 'hover:bg-[#ffd200] hover:text-[#10163f]' }} rounded">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Configuración
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="absolute bottom-0 w-64 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center p-2 w-full hover:bg-[#ffd200] hover:text-[#10163f] rounded">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>