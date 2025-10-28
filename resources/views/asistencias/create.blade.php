{{-- resources/views/asistencias/create.blade.php (ADAPTADO) --}}

{{-- 1. Usa el componente de layout de Breeze --}}
<x-app-layout>
    
    {{-- 2. Define el encabezado de la página (slot 'header') --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registrar Nueva Asistencia
        </h2>
    </x-slot>

    {{-- 3. Contenido Principal (dentro de un contenedor de Tailwind) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8">
                <div class="max-w-3xl mx-auto bg-gray-800 p-8 rounded-lg shadow-xl border border-gray-700">
                    
                    <h1 class="text-3xl font-extrabold text-white mb-6 border-b border-gray-700 pb-4">
                        <i class="fa-solid fa-clipboard-check mr-2 text-indigo-400"></i> Formulario de Asistencia
                    </h1>

                    @if ($errors->any())
                        <div class="bg-red-600 p-4 rounded-lg text-white mb-4">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('asistencias.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Docente ID --}}
                            <div>
                                <label for="docente_id" class="block text-sm font-medium text-gray-300 mb-1">Docente</label>
                                <select name="docente_id" id="docente_id" required
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccione un docente</option>
                                    @foreach ($docentes as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('docente_id') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Estado --}}
                            <div>
                                <label for="estado" class="block text-sm font-medium text-gray-300 mb-1">Estado</label>
                                <select name="estado" id="estado" required
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Seleccione estado</option>
                                    @foreach (['presente' => 'Presente', 'ausente' => 'Ausente', 'tarde' => 'Tarde'] as $value => $label)
                                        <option value="{{ $value }}" {{ old('estado') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Fecha --}}
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-300 mb-1">Fecha</label>
                                <input type="date" name="fecha" id="fecha" value="{{ old('fecha', \Carbon\Carbon::now()->format('Y-m-d')) }}" required
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            {{-- Hora (Opcional) --}}
                            <div>
                                <label for="hora" class="block text-sm font-medium text-gray-300 mb-1">Hora (Opcional)</label>
                                <input type="time" name="hora" id="hora" value="{{ old('hora', \Carbon\Carbon::now()->format('H:i')) }}"
                                       class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            {{-- Grupo Materia ID (Opcional) --}}
                            <div>
                                <label for="grupo_materia_id" class="block text-sm font-medium text-gray-300 mb-1">Grupo Materia (Opcional)</label>
                                <select name="grupo_materia_id" id="grupo_materia_id"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Ninguno</option>
                                    @foreach ($grupoMaterias as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('grupo_materia_id') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Horario ID (Opcional) --}}
                            <div>
                                <label for="horario_id" class="block text-sm font-medium text-gray-300 mb-1">Horario (Opcional)</label>
                                <select name="horario_id" id="horario_id"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Ninguno</option>
                                    @foreach ($horarios as $id => $nombre)
                                        <option value="{{ $id }}" {{ old('horario_id') == $id ? 'selected' : '' }}>
                                            {{ $nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            {{-- Tipo de Registro --}}
                            <div>
                                <label for="tipo_registro" class="block text-sm font-medium text-gray-300 mb-1">Tipo de Registro</label>
                                <select name="tipo_registro" id="tipo_registro"
                                        class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="manual" {{ old('tipo_registro', 'manual') == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="qr" {{ old('tipo_registro') == 'qr' ? 'selected' : '' }}>QR</option>
                                    <option value="codigo" {{ old('tipo_registro') == 'codigo' ? 'selected' : '' }}>Código</option>
                                </select>
                            </div>
                            
                        </div>
                        
                        {{-- Observación (Full Width) --}}
                        <div class="mt-6">
                            <label for="observacion" class="block text-sm font-medium text-gray-300 mb-1">Observación (Máx. 500 caracteres)</label>
                            <textarea name="observacion" id="observacion" rows="3"
                                      class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">{{ old('observacion') }}</textarea>
                        </div>
                        
                        <div class="flex justify-end mt-8 space-x-4">
                            <a href="{{ route('asistencias.index') }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                                Cancelar
                            </a>
                            <button type="submit" 
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150">
                                <i class="fa-solid fa-save mr-2"></i> Guardar Asistencia
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>