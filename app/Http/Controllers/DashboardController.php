<?php

namespace App\Http\Controllers;

use App\Models\Docente; // Importa el modelo
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Contar el total de docentes en la base de datos
        $docentes_count = Docente::count(); 

        // Puedes agregar más conteos aquí:
         $materias_count = \App\Models\Materia::count();
         $horarios_count = \App\Models\Horario::count();
         $users_count = \App\Models\User::count();

        // Pasa las variables a la vista 'dashboard'
        return view('pages.dashboard.dashboard', compact('docentes_count', 'materias_count', 'horarios_count', 'users_count'));
    }
}