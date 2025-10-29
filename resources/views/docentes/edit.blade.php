<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Docente: ') }} {{ $docente->user->nombre ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- FORMULARIO DE EDICIÓN --}}
                <form method="POST" action="{{ route('docentes.update', $docente) }}" class="space-y-6">
                    @csrf
                    @method('PUT') {{-- Usar método PUT para actualizaciones RESTful --}}

                    <h3 class="text-lg font-medium text-gray-900 dark:text-white border-b pb-3 mb-4">
                        Datos del Perfil Docente
                    </h3>
                    
                    {{-- Mostrar el usuario actual, ya que no se puede cambiar fácilmente --}}
                    <div class="p-3 bg-gray-700 rounded-md text-sm text-gray-300">
                        <p class="font-semibold">Usuario Asociado:</p>
                        <p>{{ $docente->user->nombre ?? 'USUARIO NO ENCONTRADO' }} ({{ $docente->user_id }})</p>
                    </div>

                    {{-- 1. CÓDIGO DEL DOCENTE --}}
                    <div>
                        <x-input-label for="codigo" :value="__('Código Docente')" />
                        {{-- Usamos old('codigo', $docente->codigo) para precargar y mantener el valor en caso de error --}}
                        <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo', $docente->codigo)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('codigo')" />
                    </div>

                    {{-- 2. FECHA DE CONTRATO Y CARGA HORARIA --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="fecha_contrato" :value="__('Fecha de Contrato')" />
                            <x-text-input id="fecha_contrato" name="fecha_contrato" type="date" class="mt-1 block w-full" :value="old('fecha_contrato', $docente->fecha_contrato?->format('Y-m-d'))" />
                            <x-input-error class="mt-2" :messages="$errors->get('fecha_contrato')" />
                        </div>
                        <div>
                            <x-input-label for="carga_horaria" :value="__('Carga Horaria (Hrs/Sem)')" />
                            <x-text-input id="carga_horaria" name="carga_horaria" type="number" class="mt-1 block w-full" :value="old('carga_horaria', $docente->carga_horaria)" required min="1" max="40" />
                            <x-input-error class="mt-2" :messages="$errors->get('carga_horaria')" />
                        </div>
                    </div>

                    {{-- 3. ESPECIALIDAD Y CATEGORÍA --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="especialidad" :value="__('Especialidad')" />
                            <x-text-input id="especialidad" name="especialidad" type="text" class="mt-1 block w-full" :value="old('especialidad', $docente->especialidad)" />
                            <x-input-error class="mt-2" :messages="$errors->get('especialidad')" />
                        </div>
                        <div>
                            <x-input-label for="categoria" :value="__('Categoría')" />
                            <select name="categoria" id="categoria" 
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="" disabled>-- Seleccione Categoría --</option>
                                {{-- Opciones de categoría con selección dinámica --}}
                                @php $currentCat = old('categoria', $docente->categoria); @endphp
                                @foreach (['Titular', 'Contratado', 'Interino'] as $cat)
                                    <option value="{{ $cat }}" @selected($currentCat == $cat)>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('categoria')" />
                        </div>
                    </div>

                    {{-- Botones de Acción --}}
                    <div class="flex items-center justify-end mt-4 space-x-3">
                        <x-secondary-button x-on:click.prevent="$dispatch('close')">
                            <a href="{{ route('docentes.index') }}">{{ __('Cancelar') }}</a>
                        </x-secondary-button>
                        
                        <x-primary-button class="ms-3">
                            <i class="fa-solid fa-floppy-disk me-2"></i>
                            {{ __('Guardar Cambios') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>