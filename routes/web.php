<?php
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\GrupoController;   
use App\Http\Controllers\GestionController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\GrupoMateriaController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\DashboardController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('asistencias', AsistenciaController::class);
Route::resource('horarios', HorarioController::class);
Route::resource('grupo_materia', GrupoMateriaController::class)->parameters([
    'grupo_materia' => 'grupoMateria', // Mapea el recurso 'grupo_materia' a la variable de ruta 'grupoMateria'
]);
Route::resource('aulas', AulaController::class);
Route::resource('modulos', ModuloController::class);
Route::resource('gestion', GestionController::class);
Route::resource('grupos', GrupoController::class);
Route::resource('materias', MateriaController::class);
Route::resource('docentes', DocenteController::class);
Route::resource('permisos', PermisoController::class);
Route::resource('users', UserController::class);
Route::resource('roles', RoleController::class);
