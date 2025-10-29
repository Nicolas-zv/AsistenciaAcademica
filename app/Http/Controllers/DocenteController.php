<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request; // Se mantiene por si se usa en otros métodos o para type-hinting
use App\Http\Requests\DocenteRequest; // Archivo de validación que ya creamos
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    /**
     * Muestra la lista de docentes con paginación y precarga la relación User.
     */
    public function index()
    {
        // Precarga la relación 'user' para evitar problemas N+1 y asegura la carga de nombres
        $docentes = Docente::with('user')->orderBy('id', 'desc')->paginate(10);
        
        return view('docentes.index', compact('docentes'));
    }

    /**
     * Muestra el formulario para crear un nuevo perfil docente.
     */
    public function create()
    {
        // Obtiene usuarios que NO tienen un perfil docente
        $usuariosDisponibles = User::whereDoesntHave('docente')
                                   ->orderBy('nombre')
                                   ->get();

        return view('docentes.create', compact('usuariosDisponibles'));
    }

    /**
     * Almacena un nuevo perfil docente en la base de datos.
     * Usa DocenteRequest para la validación.
     */
    public function store(DocenteRequest $request)
    {
        // Crea el perfil docente
        Docente::create([
            // La clave 'user_id' es el CORREO validado por DocenteRequest
            'user_id' => $request->user_id, 
            'codigo' => $request->codigo,
            'fecha_contrato' => $request->fecha_contrato,
            'carga_horaria' => $request->carga_horaria,
            'especialidad' => $request->especialidad,
            'categoria' => $request->categoria,
        ]);

        return redirect()->route('docentes.index')
                         ->with('success', '¡El perfil docente fue creado y asignado exitosamente!');
    }

    /**
     * 🔍 Muestra la información detallada de un docente específico.
     * Route Model Binding asegura que $docente sea una instancia de Docente.
     */
    public function show(Docente $docente)
    {
        // Carga el usuario asociado para mostrar los detalles
        $docente->load('user');

        return view('docentes.show', compact('docente'));
    }

    /**
     * ✏️ Muestra el formulario para editar un docente existente.
     */
    public function edit(Docente $docente)
    {
        // Carga el usuario asociado para mostrar el nombre en la vista de edición
        $docente->load('user');

        return view('docentes.edit', compact('docente'));
    }

    /**
     * 🔄 Actualiza un docente existente en la base de datos.
     * Reutiliza DocenteRequest para la validación.
     */
    public function update(DocenteRequest $request, Docente $docente)
    {
        // Actualiza solo los campos del perfil docente.
        $docente->update([
            // El campo user_id (correo) no se permite modificar después de la creación.
            'codigo' => $request->codigo,
            'fecha_contrato' => $request->fecha_contrato,
            'carga_horaria' => $request->carga_horaria,
            'especialidad' => $request->especialidad,
            'categoria' => $request->categoria,
        ]);

        // Aseguramos que la relación user esté cargada para el mensaje
        $docente->load('user');

        return redirect()->route('docentes.index')
                         ->with('success', '¡El perfil docente de ' . ($docente->user->nombre ?? $docente->user_id) . ' fue actualizado exitosamente!');
    }

    /**
     * 🗑️ Elimina un docente de la base de datos.
     */
    public function destroy(Docente $docente)
    {
        // Precargamos para obtener el nombre antes de la eliminación
        $docente->load('user'); 
        $nombreDocente = $docente->user->nombre ?? $docente->user_id; 

        // Elimina el perfil docente. El usuario asociado permanece.
        $docente->delete();

        return redirect()->route('docentes.index')
                         ->with('success', 'El perfil docente de ' . $nombreDocente . ' ha sido eliminado.');
    }
}