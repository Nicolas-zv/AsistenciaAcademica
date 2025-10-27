<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Muestra una lista paginada de materias.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $materias = Materia::orderBy('nombre', 'asc')->paginate(10);
        return view('materias.index', compact('materias'));
    }

    /**
     * Muestra el formulario para crear una nueva materia.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('materias.create');
    }

    /**
     * Almacena una materia recién creada en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sigla' => 'nullable|string|max:10|unique:materias,sigla',
            'descripcion' => 'nullable|string',
        ]);

        Materia::create($request->all());

        return redirect()->route('materias.index')
                         ->with('success', 'Materia registrada exitosamente.');
    }

    /**
     * Muestra los detalles de una materia específica.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\View\View
     */
    public function show(Materia $materia)
    {
        return view('materias.show', compact('materia'));
    }

    /**
     * Muestra el formulario para editar una materia.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\View\View
     */
    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    /**
     * Actualiza la materia especificada en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            // Asegura que la sigla sea única, ignorando el registro actual
            'sigla' => 'nullable|string|max:10|unique:materias,sigla,' . $materia->id,
            'descripcion' => 'nullable|string',
        ]);

        $materia->update($request->all());

        return redirect()->route('materias.index')
                         ->with('success', 'Materia actualizada exitosamente.');
    }

    /**
     * Elimina la materia del almacenamiento.
     *
     * @param  \App\Models\Materia  $materia
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Materia $materia)
    {
        $materia->delete();

        return redirect()->route('materias.index')
                         ->with('success', 'Materia eliminada exitosamente.');
    }
}