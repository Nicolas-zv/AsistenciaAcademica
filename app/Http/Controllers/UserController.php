<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->orderBy('id')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('nombre', 'id');
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|unique:users,correo|email|max:255',
            'password' => 'required|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
            'role_id' => 'nullable|exists:roles,id',
            'activo' => 'boolean',
        ]);

        User::create(array_merge($request->except('password'), [
            'password' => Hash::make($request->password),
        ]));

        return redirect()->route('users.index')
                         ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        dd($user);
        $roles = Role::pluck('nombre', 'id');
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:users,correo,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'telefono' => 'nullable|string|max:20',
            'role_id' => 'nullable|exists:roles,id',
            'activo' => 'boolean',
        ]);

        $data = $request->except('password', 'password_confirmation');
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
                         ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'Usuario eliminado exitosamente.');
    }
}