<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GrupoMateriaSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // materia_id 1..3, grupo_id 1..3, gestion_id 1
        DB::table('grupo_materia')->insert([
            ['materia_id' => 1, 'grupo_id' => 1, 'gestion_id' => 1, 'aula_id' => 1, 'modulo_id' => 1, 'turno' => 'Mañana', 'cupo' => 40, 'estado' => 'activo', 'created_at' => $now, 'updated_at' => $now],
            ['materia_id' => 2, 'grupo_id' => 2, 'gestion_id' => 1, 'aula_id' => 2, 'modulo_id' => 2, 'turno' => 'Tarde', 'cupo' => 30, 'estado' => 'activo', 'created_at' => $now, 'updated_at' => $now],
            ['materia_id' => 3, 'grupo_id' => 3, 'gestion_id' => 1, 'aula_id' => 1, 'modulo_id' => 1, 'turno' => 'Noche', 'cupo' => 25, 'estado' => 'activo', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}