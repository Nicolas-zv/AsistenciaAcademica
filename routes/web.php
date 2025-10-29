<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AsistenciaController; // <--- ¡Asegúrate de importar tu controlador!
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GrupoController;   
use App\Http\Controllers\GestionController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\GrupoMateriaController;
use App\Http\Controllers\HorarioController;
use Illuminate\Support\Facades\Auth;
// ... otras importaciones

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    // 2. Si no está logueado, muestra la página de bienvenida (o lo que quieras).
    return view('inicio'); 
    })->name('home');
    Route::middleware('auth')->group(function () {
        
        // Rutas protegidas por 'auth'

        // 1. DASHBOARD ÚNICO Y CORRECTO:
        // Esta es la única definición que debe existir para /dashboard.
        // Usa la notación de punto para encontrar tu vista: views/pages/dashboard/dashboard.blade.php
    Route::get('/dashboard', [DashboardController::class, 'index']) // <--- Corregido para usar el controlador
        ->middleware('verified')->name('dashboard');

    Route::resource('aulas', AulaController::class);
    Route::resource('modulos', ModuloController::class);
    Route::resource('gestion', GestionController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('materias', MateriaController::class);

    Route::resource('permisos', PermisoController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);  
    Route::resource('grupo_materia', GrupoMateriaController::class);
    Route::resource('horarios', HorarioController::class);
        // 2. CRUD DE ASISTENCIAS
        Route::resource('asistencias', AsistenciaController::class);
    Route::resource('docentes', DocenteController::class);
    // 3. PERFIL DE USUARIO
    // ... (Rutas de ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
