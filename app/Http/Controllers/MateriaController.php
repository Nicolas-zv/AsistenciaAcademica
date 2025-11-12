<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('nombre', 'asc')->paginate(10);
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sigla' => 'nullable|string|max:10|unique:materias,sigla',
            'descripcion' => 'nullable|string',
        ]);

        $materia = Materia::create($request->all());


        activity()
            ->performedOn($materia)
            ->withProperties(['usuario' => Auth::user()->nombre])
            ->log('Se creó una nueva materia: ' . $materia->id . ' - Nombre: ' . $materia->nombre);


        return redirect()->route('materias.index')
            ->with('success', 'Materia registrada exitosamente.');
    }

    public function show(Materia $materia)
    {
        return view('materias.show', compact('materia'));
    }

    public function edit(Materia $materia)
    {
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, Materia $materia)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'sigla' => 'nullable|string|max:10|unique:materias,sigla,' . $materia->id,
            'descripcion' => 'nullable|string',
        ]);

        $materia->update($request->all());

        activity()
            ->performedOn($materia) // ✅ usa el modelo actualizado
            ->causedBy(Auth::user())
            ->log("Materia actualizada: {$materia->nombre} ({$materia->sigla})");

        return redirect()->route('materias.index')
            ->with('success', 'Materia actualizada exitosamente.');
    }

    public function destroy(Materia $materia)
    {
        $nombre = $materia->nombre;
        $sigla = $materia->sigla;

        activity()
            ->performedOn($materia) // ✅ usa el modelo antes de eliminarlo
            ->causedBy(Auth::user())
            ->log("Materia eliminada: {$nombre} ({$sigla})");

        $materia->delete();

        return redirect()->route('materias.index')
            ->with('success', 'Materia eliminada exitosamente.');
    }
}
