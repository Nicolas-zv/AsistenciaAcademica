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
            ['nombre' => 'admin', 'descripcion' => 'Administrador', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'coordinador', 'descripcion' => 'Coordinador', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'docente', 'descripcion' => 'Docente', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'secretaria', 'descripcion' => 'Secretaría', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}