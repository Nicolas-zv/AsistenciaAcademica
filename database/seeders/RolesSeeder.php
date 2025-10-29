<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('roles')->insert([
            ['nombre' => 'admin', 'descripcion' => 'Gestión operativa y académica', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Jefe de Carrera', 'descripcion' => 'Supervisión académica', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'docente', 'descripcion' => 'Usuario académico principal', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Analista Academico', 'descripcion' => 'Análisis y control de datos', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Soporte técnico', 'descripcion' => 'Mantenimiento y respaldo del sistema', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}