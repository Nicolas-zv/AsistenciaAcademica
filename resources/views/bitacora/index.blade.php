<x-app-layout>
    <div class="max-w-6xl mx-auto p-6 bg-white dark:bg-gray-900 shadow-md rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4">
            🧾 Bitácora de Actividades
        </h1>

        {{-- 🔍 FILTRO POR FECHAS --}}
        <form method="GET" action="{{ route('bitacora.index') }}" class="mb-4 flex flex-col sm:flex-row items-center gap-3">
            <div>
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio"
                    value="{{ request('fecha_inicio') }}"
                    class="border rounded px-3 py-1 dark:bg-gray-800 dark:text-white" />
            </div>

            <div>
                <label for="fecha_fin" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha final:</label>
                <input type="date" id="fecha_fin" name="fecha_fin"
                    value="{{ request('fecha_fin') }}"
                    class="border rounded px-3 py-1 dark:bg-gray-800 dark:text-white" />
            </div>

            <div class="pt-5">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    Filtrar
                </button>
                <a href="{{ route('bitacora.index') }}"
                    class="ml-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                    Limpiar
                </a>
            </div>
        </form>

        {{-- TABLA DE ACTIVIDADES --}}
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">#</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Usuario</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Acción</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Modelo</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Fecha</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($actividades as $actividad)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $actividad->id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ $actividad->properties['usuario'] ?? $actividad->causer?->nombre ?? 'Sistema' }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ $actividad->description }}
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ class_basename($actividad->subject_type) }}
                            @if ($actividad->subject_id)
                                (#{{ $actividad->subject_id }})
                            @endif
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ $actividad->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 dark:text-gray-400 py-4">
                            No hay actividades registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $actividades->links() }}
        </div>
    </div>
</x-app-layout>
