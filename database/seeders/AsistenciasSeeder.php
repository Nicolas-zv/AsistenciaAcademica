<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsistenciasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // docentes id 1..2, registrado_por usuario id 5 (secretaria) por ejemplo
        DB::table('asistencias')->insert([
            ['docente_id' => 1, 'grupo_materia_id' => 1, 'horario_id' => 1, 'fecha' => $now->toDateString(), 'hora' => '08:00:00', 'estado' => 'presente', 'observacion' => 'A tiempo', 'tipo_registro' => 'manual', 'registrado_por' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['docente_id' => 2, 'grupo_materia_id' => 2, 'horario_id' => 3, 'fecha' => $now->subDay()->toDateString(), 'hora' => '10:00:00', 'estado' => 'ausente', 'observacion' => 'No presentó', 'tipo_registro' => 'qr', 'registrado_por' => 5, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}