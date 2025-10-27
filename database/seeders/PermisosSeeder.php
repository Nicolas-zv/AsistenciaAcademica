<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermisosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('permisos')->insert([
            ['nombre' => 'ver_horarios', 'descripcion' => 'Ver horarios', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'asignar_horarios', 'descripcion' => 'Asignar horarios', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'registrar_asistencia', 'descripcion' => 'Registrar asistencia', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'administrar_usuarios', 'descripcion' => 'Administrar usuarios', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}