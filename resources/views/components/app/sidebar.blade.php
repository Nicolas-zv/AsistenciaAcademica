{{-- resources/views/components/app/sidebar.blade.php --}}

<div class="space-y-6 flex-grow">

    {{-- SECCIÓN: Catálogos --}}
    <div>
        <ul class="mt-3">

            {{-- Siempre visible --}}
            <x-app.sidebar-link route="dashboard" icon='<i class="fa-solid fa-table-columns"></i>' label="Dashboard" />

            {{-- 🔐 Visible solo para ciertos roles --}}
            @php
                $rol = Auth::user()->role->nombre ?? null;
            @endphp

            @if (in_array($rol, ['admin', 'Jefe de Carrera', 'Analista Academico']))
                <x-app.sidebar-link route="docentes.index" icon='<i class="fa-solid fa-user-tie"></i>' label="Docentes" />
                <x-app.sidebar-link route="materias.index" icon='<i class="fa-solid fa-book"></i>' label="Materias" />
                <x-app.sidebar-link route="grupos.index" icon='<i class="fa-solid fa-layer-group"></i>'
                    label="Grupos" />
                <x-app.sidebar-link route="modulos.index" icon='<i class="fa-solid fa-th-large"></i>' label="Módulos" />
                <x-app.sidebar-link route="aulas.index" icon='<i class="fa-solid fa-chalkboard"></i>' label="Aulas" />
                <x-app.sidebar-link route="gestion.index" icon='<i class="fa-solid fa-calendar-days"></i>'
                    label="Gestiones" />
                <x-app.sidebar-link route="grupo_materia.index" icon='<i class="fa-solid fa-layer-group"></i>'
                    label="Grupo-Materia" />
                <x-app.sidebar-link route="horarios.index" icon='<i class="fa-solid fa-calendar-days"></i>'
                    label="Horarios" />
                <x-app.sidebar-link route="asistencias.index" icon='<i class="fa-solid fa-clock"></i>'
                    label="Asistencias" />
                <x-app.sidebar-link route="reportes.index" icon='<i class="fa-solid fa-chart-bar"></i>'
                    label="Reportes Generales" />
            @endif

        </ul>
    </div>

    {{-- SECCIÓN: Docente --}}
    <div>
        <ul class="mt-3">
            @if ($rol === 'docente')
                <x-app.sidebar-link route="marcar.index" icon='<i class="fa-solid fa-user-group"></i>'
                    label="Mis Asistencias" />
                <x-app.sidebar-link route="marcar.create" icon='<i class="fa-solid fa-user-group"></i>'
                    label="Marcar Asistencia" />
            @endif
        </ul>
    </div>



    {{-- SECCIÓN: Administración --}}
    <div>
        <ul class="mt-3">
            @if ($rol === 'admin')
                <x-app.sidebar-link route="users.index" icon='<i class="fa-solid fa-user-group"></i>'
                    label="Usuarios" />
                <x-app.sidebar-link route="roles.index" icon='<i class="fa-solid fa-shield-halved"></i>'
                    label="Roles" />
                <x-app.sidebar-link route="permisos.index" icon='<i class="fa-solid fa-key"></i>' label="Permisos" />
                <x-app.sidebar-link route="bitacora.index" icon='<i class="fa-solid fa-shield-halved"></i>'
                    label="Bitacora" />
            @endif
        </ul>
    </div>
</div>
