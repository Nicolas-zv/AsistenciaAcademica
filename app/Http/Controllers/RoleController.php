<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id')->paginate(10);
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:roles,nombre|max:255',
            'descripcion' => 'nullable|max:255',
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')
                         ->with('success', 'Rol creado exitosamente.');
    }

    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        // 1. Aquí se usa el MODELO 'Permission' (la clase) para consultar la tabla 'permisos'.
        $permisos = Permission::all(); 

        // 2. Obtiene los IDs de los permisos ya asignados al rol
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        // 3. Pasa la colección de permisos a la vista.
        return view('roles.edit', [
            'role' => $role,
            'permisos' => $permisos, // <-- ¡Esto resuelve el error en la vista!
            'rolePermissions' => $rolePermissions,
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nombre' => 'required|unique:roles,nombre,' . $role->id . '|max:255',
            'descripcion' => 'nullable|max:255',
        ]);

        $role->update($request->all());

        return redirect()->route('roles.index')
                         ->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
                         ->with('success', 'Rol eliminado exitosamente.');
    }
}