<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Docente;
use Carbon\Carbon;

class GrupoMateriaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // ✅ Obtener los IDs numéricos de los docentes existentes
        $docente1_id = Docente::where('codigo', 'DOC-001')->value('id');
        $docente2_id = Docente::where('codigo', 'DOC-002')->value('id');

        // ⚠️ Validar que existan los docentes antes de insertar
        if (!$docente1_id || !$docente2_id) {
            $this->command->warn('⚠️ No se encontraron los docentes requeridos (DOC-001 o DOC-002).
Ejecuta primero el DocentesSeeder para crear esos registros.');
            return;
        }

        // ✅ Insertar grupos de materias con el docente_id correcto (numérico)
        DB::table('grupo_materia')->insert([
            [
                'materia_id' => 1,
                'grupo_id' => 1,
                'gestion_id' => 1,
                'docente_id' => $docente1_id, // ID numérico del docente
                'aula_id' => 1,
                'modulo_id' => 1,
                'turno' => 'Mañana',
                'cupo' => 40,
                'estado' => 'activo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'materia_id' => 2,
                'grupo_id' => 2,
                'gestion_id' => 1,
                'docente_id' => $docente2_id, // ID numérico del docente
                'aula_id' => 2,
                'modulo_id' => 1,
                'turno' => 'Tarde',
                'cupo' => 30,
                'estado' => 'activo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'materia_id' => 3,
                'grupo_id' => 3,
                'gestion_id' => 1,
                'docente_id' => null, // sin docente asignado
                'aula_id' => 1,
                'modulo_id' => 1,
                'turno' => 'Noche',
                'cupo' => 25,
                'estado' => 'activo',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
