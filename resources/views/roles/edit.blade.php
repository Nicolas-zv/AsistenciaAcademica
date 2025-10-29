{{-- resources/views/roles/edit.blade.php --}}

<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Editar Rol
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">

                <h1 class="text-3xl font-extrabold text-indigo-400 dark:text-indigo-400 mb-6 border-b border-gray-700 dark:border-gray-700 pb-3">
                    Editar Rol: <span class="text-white dark:text-white">{{ $role->nombre }}</span>
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

                <form method="POST" action="{{ route('roles.update', $role) }}" 
                      class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl border border-gray-700 dark:border-gray-700 max-w-2xl mx-auto">
                    @csrf
                    @method('PUT')

                    {{-- Sección: Datos Generales del Rol --}}
                    <div class="mb-8 pb-4 border-b border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-200 mb-4">Información Básica</h2>

                        {{-- Nombre del Rol --}}
                        <div class="mb-4">
                            <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre del Rol <span class="text-red-500">*</span></label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $role->nombre) }}" required 
                                   class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('nombre') border-red-500 @enderror"
                                   autofocus>
                            @error('nombre')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción (Opcional)</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                      class="mt-1 block w-full bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $role->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Sección: Asignación de Permisos --}}
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-200 mb-4 border-b border-gray-700 pb-2">Asignar Permisos</h2>
                        
                        <p class="text-sm text-gray-400 mb-4">Selecciona los permisos que este rol debe tener. (Asumiendo que `$permisos` y `$rolePermissions` están disponibles en el controlador).</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($permisos as $permiso)
                                @php
                                    // Comprueba si el permiso está asignado al rol
                                    $checked = in_array($permiso->id, $rolePermissions) ? 'checked' : '';
                                @endphp
                                <div class="flex items-center">
                                    <input type="checkbox" name="permissions[]" id="permiso_{{ $permiso->id }}" value="{{ $permiso->id }}" {{ $checked }}
                                           class="h-4 w-4 text-indigo-600 dark:bg-gray-700 border-gray-600 rounded focus:ring-indigo-500">
                                    <label for="permiso_{{ $permiso->id }}" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                                        {{ $permiso->nombre }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <p class="mt-2 text-xs text-red-400">Debe seleccionar al menos un permiso.</p>
                        @enderror
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex justify-end pt-4 border-t border-gray-700 dark:border-gray-700">
                        <a href="{{ route('roles.index') }}" 
                           class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition duration-150 mr-4">
                            **Cancelar**
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700 transition duration-150 shadow-md">
                            **Actualizar Rol**
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>