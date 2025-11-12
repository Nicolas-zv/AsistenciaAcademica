<x-app-layout>
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-900 shadow rounded-lg p-6 mt-6">
        <h1 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">
            🕒 Marcar Asistencia
        </h1>

        <form method="POST" action="{{ route('marcar.store') }}" class="space-y-4">
            @csrf

            {{-- Grupo Materia --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Materia - Grupo</label>
                <select name="grupo_materia_id" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-gray-200" required>
                    <option value="">Seleccione...</option>
                    @foreach ($grupoMateriasMap as $id => $nombre)
                        <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
                @error('grupo_materia_id')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Fecha --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Fecha</label>
                <input type="date" name="fecha" value="{{ now()->toDateString() }}"
                    class="w-full border rounded p-2 dark:bg-gray-800 dark:text-gray-200" required>
                @error('fecha')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Hora --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Hora</label>
                <input type="time" name="hora" value="{{ now()->format('H:i') }}"
                    class="w-full border rounded p-2 dark:bg-gray-800 dark:text-gray-200" required>
                @error('hora')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Estado --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Estado</label>
                <select name="estado" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-gray-200" required>
                    <option value="presente">Presente</option>
                    <option value="tarde">Tarde</option>
                    <option value="ausente">Ausente</option>
                </select>
                @error('estado')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            {{-- Observación --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300 mb-1">Observación (opcional)</label>
                <textarea name="observacion" rows="3" class="w-full border rounded p-2 dark:bg-gray-800 dark:text-gray-200"></textarea>
            </div>

            {{-- Botón --}}
            <div class="pt-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-4 py-2 rounded">
                    ✅ Guardar Asistencia
                </button>
                <a href="{{ route('marcar.index') }}"
                    class="ml-2 text-gray-600 dark:text-gray-300 hover:underline">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
