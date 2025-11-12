<x-app-layout>
    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-900 p-6 shadow rounded-lg mt-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-4">📋 Mis Asistencias Registradas</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800">
                <tr>
                    <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Fecha</th>
                    <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Materia / Grupo</th>
                    <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Estado</th>
                    <th class="px-3 py-2 text-left text-sm font-semibold text-gray-700 dark:text-gray-300">Observación</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse ($asistenciasdocente as $a)
                    <tr>
                        <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $a->fecha }}</td>
                        <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">
                            {{ $a->grupoMateria->materia->sigla ?? 'N/A' }}
                            ({{ $a->grupoMateria->gestion->año ?? 'N/A' }})
                        </td>
                        <td class="px-3 py-2 text-sm font-semibold
                            {{ $a->estado === 'presente' ? 'text-green-600' : ($a->estado === 'tarde' ? 'text-yellow-600' : 'text-red-600') }}">
                            {{ ucfirst($a->estado) }}
                        </td>
                        <td class="px-3 py-2 text-sm text-gray-700 dark:text-gray-300">{{ $a->observacion ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500 dark:text-gray-400">No tienes asistencias registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $asistenciasdocente->links() }}
        </div>

        <div class="mt-6">
            <a href="{{ route('marcar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                ➕ Registrar nueva asistencia
            </a>
        </div>
    </div>
</x-app-layout>
