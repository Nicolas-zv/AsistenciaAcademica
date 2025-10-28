{{-- resources/views/components/app/sidebar-link.blade.php --}}
@props(['route', 'icon', 'label'])

@php
    // Obtener la ruta actual para la clase activa
    // Usamos el nombre de la ruta. Si la ruta es 'docentes.index', 
    // y la URL actual es '/docentes', Laravel lo resuelve automáticamente.
    // Usamos '.*' para que coincida con todas las acciones del recurso (index, create, edit, show).
    $active = request()->routeIs($route) || request()->routeIs($route . '.*');
    
    // El bloque 'if (!$active)' anterior que usaba str_contains es eliminado 
    // porque ya no es necesario; routeIs() maneja esto mejor.

    // Definición de Clases
    $activeClasses = 'bg-indigo-700/50 ring-2 ring-indigo-500 border-l-4 border-indigo-400';
    $inactiveClasses = 'hover:bg-gray-700/50';
    $iconActiveClasses = 'text-indigo-400 font-bold';
    $iconInactiveClasses = 'text-gray-300';
    $textInactiveClasses = 'hover:text-indigo-300';
@endphp

<li class="pl-4 pr-3 py-2 rounded-lg mb-0.5 last:mb-0 transition duration-150 ease-in-out {{ $active ? $activeClasses : $inactiveClasses }}">
    {{-- ¡CORREGIDO! Usar route($route) para generar la URL correcta --}}
    <a class="block text-gray-100 truncate transition {{ !$active ? $textInactiveClasses : '' }}" href="{{ route($route) }}">
        <div class="flex items-center">
            <span class="text-lg shrink-0 {{ $active ? $iconActiveClasses : $iconInactiveClasses }}">{!! $icon !!}</span>
            <span class="text-sm font-medium ml-4 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">{{ $label }}</span>
        </div>
    </a>
</li>