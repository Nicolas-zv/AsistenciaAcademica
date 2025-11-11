{{-- resources/views/asistencias/justificar.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Justificar Inasistencia (CU14)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 p-6 sm:p-8 rounded-lg shadow-xl border border-gray-700">

                <h1 class="text-2xl font-extrabold text-white mb-4 border-b border-gray-700 pb-2">
                    <i class="fa-solid fa-file-signature mr-2 text-yellow-400"></i> Justificar Inasistencia
                </h1>
                
                {{-- Resumen del Registro a Justificar --}}
                <div class="bg-gray-700 p-4 rounded-lg mb-6 border border-gray-600">
                    <p class="text-gray-300">
                        **Docente:** {{ optional($asistencia->docente->user)->nombre ?? 'Docente ID: ' . $asistencia->docente_id }}
                    </p>
                    <p class="text-gray-300">
                        **Fecha/Hora:** {{ $asistencia->fecha }} a las {{ $asistencia->hora }}
                    </p>
                    <p class="text-gray-300">
                        **Estado a Modificar:** <span class="uppercase font-bold text-red-400">{{ $asistencia->estado }}</span>
                    </p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-600 p-4 rounded-lg text-white mb-4">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('asistencias.justificar.update', $asistencia) }}">
                    @csrf
                    @method('PUT') {{-- Usar PUT para actualizar el registro --}}

                    <div class="mb-4">
                        <label for="motivo" class="block text-sm font-medium text-gray-300 mb-1">Motivo de la Justificación (Adjuntar documento si aplica)</label>
                        <textarea name="motivo" id="motivo" rows="5" required
                            class="w-full bg-gray-700 border border-gray-600 text-white rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Escriba la razón de la inasistencia (ej. Licencia por enfermedad, comisión, etc.)">{{ old('motivo', $asistencia->motivo_justificacion) }}</textarea>
                        @error('motivo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <a href="{{ route('asistencias.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition">
                            <i class="fa-solid fa-check-double mr-2"></i> Confirmar Justificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>