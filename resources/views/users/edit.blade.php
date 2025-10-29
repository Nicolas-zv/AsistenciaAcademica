{{-- resources/views/users/edit.blade.php --}}

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Editar Usuario: <span class="text-white dark:text-white">{{ $user->nombre }}</span>
                </h1>

                {{-- Manejo de Errores --}}
                @if ($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-200 bg-red-900/70 rounded-lg border border-red-700 dark:bg-red-900/70 dark:border-red-700">
                        <p class="font-bold mb-1">Por favor, corrija los siguientes errores:</p>
                        <ul class="list-disc list-inside ml-4">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('users.update', $user) }}" 
                      class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-lg mx-auto">
                    @csrf
                    @method('PUT')

                    {{-- Nombre Completo --}}
                    <div class="mb-4">
                        <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre Completo</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $user->nombre) }}" required 
                               class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror" autofocus>
                    </div>

                    {{-- Correo Electrónico --}}
                    <div class="mb-4">
                        <label for="correo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Correo Electrónico</label>
                        <input type="email" name="correo" id="correo" value="{{ old('correo', $user->correo) }}" required 
                               class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('correo') border-red-500 @enderror">
                    </div>
                    
                    {{-- Rol --}}
                    <div class="mb-4">
                        <label for="role_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rol</label>
                        <select name="role_id" id="role_id" required 
                                class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('role_id') border-red-500 @enderror">
                            <option value="">Seleccionar Rol</option>
                            @foreach ($roles as $id => $nombre)
                                <option value="{{ $id }}" {{ old('role_id', $user->role_id) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    {{-- Estado (Activo/Inactivo) --}}
                    <div class="mb-6">
                        <label for="activo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                        <select name="activo" id="activo" required 
                                class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="1" {{ old('activo', $user->activo) == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('activo', $user->activo) == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 border-t border-gray-700 pt-4">Dejar los campos de contraseña vacíos si no deseas cambiarlos.</p>

                    {{-- Contraseña --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nueva Contraseña</label>
                        <input type="password" name="password" id="password" 
                               class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
                    </div>
                    
                    {{-- Confirmar Contraseña --}}
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-end pt-4 border-t border-gray-700 dark:border-gray-700">
                        <a href="{{ route('users.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 mr-4">
                            **Cancelar**
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition duration-150 shadow-md">
                            **Actualizar Usuario**
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>