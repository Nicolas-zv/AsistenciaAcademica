<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('¿Olvidaste tu contraseña? No hay problema. Simplemente dinos tu dirección de correo y te enviaremos un enlace para restablecer la contraseña que te permitirá elegir una nueva.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            {{-- Cambiamos 'Email' por 'Correo' en la etiqueta --}}
            <x-input-label for="correo" :value="__('Correo')" /> 
            
            <x-text-input 
                id="correo" 
                class="block mt-1 w-full" 
                type="email" 
                name="correo" {{-- <--- CAMBIO CLAVE: name="correo" --}}
                :value="old('correo')" 
                required 
                autofocus 
            />
            {{-- Cambiamos la referencia a 'correo' para mostrar el error --}}
            <x-input-error :messages="$errors->get('correo')" class="mt-2" /> 
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar Enlace para Restablecer Contraseña') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>