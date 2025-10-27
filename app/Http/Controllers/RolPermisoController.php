<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permiso;
use Illuminate\Http\Request;

class RolePermisoController extends Controller
{
    /**
     * Muestra el formulario con checkboxes para editar los permisos de un rol.
     * * @param  \App\Models\Role  $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {
        // 1. Obtener todos los permisos disponibles en el sistema
        $permisos = Permiso::orderBy('nombre')->get();
        
        // 2. Obtener los IDs de los permisos que este rol YA tiene asignados
        // Esto es crucial para marcar los checkboxes como 'checked' en la vista.
        $permisosActualesIds = $role->permisos->pluck('id')->toArray();

        // Carga la vista con el rol, todos los permisos y los IDs asignados
        return view('role_permiso.edit', compact('role', 'permisos', 'permisosActualesIds'));
    }

    /**
     * Sincroniza (actualiza) los permisos del rol en la tabla pivot 'rol_permisos'.
     * * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Role $role)
    {
        // 1. Validación de la petición
        $request->validate([
            // 'permisos' puede ser nulo (si no se marca nada) o un array de IDs
            'permisos' => 'nullable|array',
            'permisos.*' => 'exists:permisos,id', // Asegura que cada ID existe en la tabla permisos
        ]);

        // 2. Sincronización de la relación
        // El método sync() es la herramienta clave para Many-to-Many:
        // - Inserta los IDs de permisos que faltan.
        // - Elimina los IDs de permisos que fueron desmarcados.
        // - Ignora los IDs que ya existen.
        $role->permisos()->sync($request->input('permisos', []));

        // 3. Redirección con mensaje de éxito
        return redirect()->route('roles.index') 
                         ->with('success', "Permisos actualizados exitosamente para el rol '{$role->nombre}'.");
    }
}