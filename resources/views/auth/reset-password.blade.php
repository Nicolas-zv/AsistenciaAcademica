<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            {{-- Cambiado 'Email' a 'Correo' en la etiqueta --}}
            <x-input-label for="correo" :value="__('Correo')" />
            <x-text-input 
                id="correo" 
                class="block mt-1 w-full" 
                type="email" 
                name="correo" {{-- <--- CAMBIO CLAVE: name="correo" --}}
                :value="old('correo', $request->email)" {{-- Usar old('correo') y mantener $request->email para precargar --}}
                required 
                autofocus 
                autocomplete="username" 
            />
            {{-- Cambiado 'email' a 'correo' para mostrar el error --}}
            <x-input-error :messages="$errors->get('correo')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Restablecer Contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>