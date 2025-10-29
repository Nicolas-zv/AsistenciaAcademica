<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Importar el modelo User
use App\Models\Docente; // Importar el modelo Docente
use Carbon\Carbon;

class GrupoMateriaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 🚀 Solución: Obtener las claves primarias (correos) de los docentes.
        // ASUMIMOS que los docentes con código DOC-001 y DOC-002 existen.

        // 1. Obtener los DOCENTES por su código (o por cualquier campo único)
        $docente1_user_id = Docente::where('codigo', 'DOC-001')->value('user_id');
        $docente2_user_id = Docente::where('codigo', 'DOC-002')->value('user_id');

        if (!$docente1_user_id || !$docente2_user_id) {
            $this->command->warn('No se encontraron los docentes requeridos (DOC-001 o DOC-002). Asegúrese de ejecutar DocentesSeeder primero.');
            return;
        }

        DB::table('grupo_materia')->insert([
            // 💡 Usar el user_id del docente (que es el correo electrónico)
            ['materia_id' => 1, 'grupo_id' => 1, 'gestion_id' => 1, 'docente_id' => $docente1_user_id, 'aula_id' => 1, 'modulo_id' => 1, 'turno' => 'Mañana', 'cupo' => 40, 'estado' => 'activo', 'created_at' => $now, 'updated_at' => $now],
            
            ['materia_id' => 2, 'grupo_id' => 2, 'gestion_id' => 1, 'docente_id' => $docente2_user_id, 'aula_id' => 2, 'modulo_id' => 1, 'turno' => 'Tarde', 'cupo' => 30, 'estado' => 'activo', 'created_at' => $now, 'updated_at' => $now],
            
            // Este sigue bien (sin docente)
            ['materia_id' => 3, 'grupo_id' => 3, 'gestion_id' => 1, 'docente_id' => null, 'aula_id' => 1, 'modulo_id' => 1, 'turno' => 'Noche', 'cupo' => 25, 'estado' => 'activo', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}