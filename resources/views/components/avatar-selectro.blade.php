<div x-data="{ showAvatarOptions: false }">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-medium mb-4">Avatar</h3>
        
        <!-- Vista previa del avatar actual -->
        <div class="flex items-center mb-4">
            @if($user->avatar)
                <img src="{{ $user->avatar }}" alt="Avatar actual" class="w-20 h-20 rounded-full object-cover">
            @elseif($user->avatar_color)
                <div class="w-20 h-20 rounded-full flex items-center justify-center text-white text-2xl"
                     style="background-color: {{ $user->avatar_color }}">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @else
                <div class="w-20 h-20 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-2xl">
                    {{ substr($user->name, 0, 1) }}
                </div>
            @endif
        </div>

        <!-- Opciones de avatar -->
        <div class="space-y-4">
            <!-- Subir imagen -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Subir imagen</label>
                <input type="file" 
                       name="avatar_image" 
                       accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#10163f] file:text-white hover:file:bg-[#ffd200] hover:file:text-[#10163f]">
            </div>

            <!-- O elegir color -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">O elige un color</label>
                <div class="grid grid-cols-4 gap-2">
                    @php
                    $colors = [
                        '#4F46E5', '#10B981', '#F59E0B', '#EF4444', 
                        '#8B5CF6', '#EC4899', '#10163f', '#ffd200',
                        '#14B8A6', '#F97316', '#06B6D4', '#6366F1'
                    ];
                    @endphp

                    @foreach($colors as $index => $color)
                    <button type="button"
                            onclick="document.getElementById('avatar_preset').value = 'avatar-{{ $index + 1 }}'"
                            class="w-10 h-10 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#10163f]"
                            style="background-color: {{ $color }}">
                    </button>
                    @endforeach
                </div>
                <input type="hidden" name="avatar_preset" id="avatar_preset">
            </div>
        </div>
    </div>
</div>