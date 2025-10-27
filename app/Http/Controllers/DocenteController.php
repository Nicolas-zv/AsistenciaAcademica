<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User; // Necesitamos el modelo User para la selección
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::with('user')->orderBy('id', 'desc')->paginate(10);
        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        // Obtener solo usuarios que NO son docentes todavía (user_id IS NULL en la tabla docentes)
        $usuariosDisponibles = User::whereDoesntHave('docente')->get();
        return view('docentes.create', compact('usuariosDisponibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:docentes,user_id',
            'codigo' => 'nullable|unique:docentes,codigo|max:20',
            'fecha_contrato' => 'nullable|date',
            'carga_horaria' => 'required|integer|min:0',
            'especialidad' => 'nullable|string|max:100',
            'categoria' => 'nullable|string|max:50',
        ]);

        Docente::create($request->all());

        return redirect()->route('docentes.index')
                         ->with('success', 'Docente registrado exitosamente.');
    }

    public function show(Docente $docente)
    {
        // Carga la relación user
        $docente->load('user');
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente)
    {
        // Para editar, obtenemos todos los usuarios disponibles más el usuario actual del docente.
        $usuariosDisponibles = User::whereDoesntHave('docente')
                                   ->orWhere('id', $docente->user_id)
                                   ->get();
                                   
        return view('docentes.edit', compact('docente', 'usuariosDisponibles'));
    }

    public function update(Request $request, Docente $docente)
    {
        $request->validate([
            // La validación del user_id debe ignorar el ID actual del docente
            'user_id' => 'required|exists:users,id|unique:docentes,user_id,' . $docente->id,
            'codigo' => 'nullable|unique:docentes,codigo,' . $docente->id . '|max:20',
            'fecha_contrato' => 'nullable|date',
            'carga_horaria' => 'required|integer|min:0',
            'especialidad' => 'nullable|string|max:100',
            'categoria' => 'nullable|string|max:50',
        ]);

        $docente->update($request->all());

        return redirect()->route('docentes.index')
                         ->with('success', 'Datos del docente actualizados exitosamente.');
    }

    public function destroy(Docente $docente)
    {
        $docente->delete();

        return redirect()->route('docentes.index')
                         ->with('success', 'Docente eliminado exitosamente.');
    }
}