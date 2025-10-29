<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HorariosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // grupo_materia_id 1..3
        DB::table('horarios')->insert([
            ['grupo_materia_id' => 1, 'dia' => 1, 'hora_inicio' => '08:00:00', 'hora_fin' => '10:00:00', 'modalidad' => 'presencial', 'estado' => 'programado', 'created_at' => $now, 'updated_at' => $now],
            ['grupo_materia_id' => 1, 'dia' => 3, 'hora_inicio' => '08:00:00', 'hora_fin' => '10:00:00', 'modalidad' => 'presencial', 'estado' => 'programado', 'created_at' => $now, 'updated_at' => $now],
            ['grupo_materia_id' => 2, 'dia' => 2, 'hora_inicio' => '10:00:00', 'hora_fin' => '12:00:00', 'modalidad' => 'presencial', 'estado' => 'programado', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}