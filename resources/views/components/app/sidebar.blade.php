{{-- resources/views/components/app/sidebar.blade.php --}}

{{-- Contenido de Navegación --}}
<div class="space-y-6 flex-grow">
    
    {{-- Elimina el BLOQUE @php function renderSidebarLink()... @endphp aquí --}}
    
    {{-- SECCIÓN: Catálogos --}}
    <div>
        <ul class="mt-3">
            
            {{-- ✅ NUEVA SINTAXIS: Usando el componente --}}
            <x-app.sidebar-link route="dashboard" icon='<i class="fa-solid fa-table-columns"></i>' label="Dashboard" />
            <x-app.sidebar-link route="docentes.index" icon='<i class="fa-solid fa-user-tie"></i>' label="Docentes" />
            <x-app.sidebar-link route="materias.index" icon='<i class="fa-solid fa-book"></i>' label="Materias" />
            <x-app.sidebar-link route="grupos.index" icon='<i class="fa-solid fa-layer-group"></i>' label="Grupos" />
            <x-app.sidebar-link route="modulos.index" icon='<i class="fa-solid fa-th-large"></i>' label="Módulos" />
            <x-app.sidebar-link route="aulas.index" icon='<i class="fa-solid fa-chalkboard"></i>' label="Aulas" />
            <x-app.sidebar-link route="gestion.index" icon='<i class="fa-solid fa-calendar-days"></i>' label="Gestiones" />
            <x-app.sidebar-link route="grupo_materia.index" icon='<i class="fa-solid fa-layer-group"></i>' label="Grupo-Materia" /> 
            <x-app.sidebar-link route="horarios.index" icon='<i class="fa-solid fa-calendar-days"></i>' label="Horarios" />
            <x-app.sidebar-link route="asistencias.index" icon='<i class="fa-solid fa-clock"></i>' label="Asistencias" />
            <x-app.sidebar-link route="reportes.index" icon='<i class="fa-solid fa-chart-bar"></i>' label="Reportes Generales" />
        </ul>
    </div>

    {{-- SECCIÓN: Administración --}}
    <div>
        <ul class="mt-3">
            <x-app.sidebar-link route="users.index" icon='<i class="fa-solid fa-user-group"></i>' label="Usuarios" />
            <x-app.sidebar-link route="roles.index" icon='<i class="fa-solid fa-shield-halved"></i>' label="Roles" />
            <x-app.sidebar-link route="permisos.index" icon='<i class="fa-solid fa-key"></i>' label="Permisos" />
        </ul>
    </div>
    
</div>