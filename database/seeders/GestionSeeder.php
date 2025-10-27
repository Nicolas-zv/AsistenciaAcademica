<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GestionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('gestion')->insert([
            ['año' => 2025, 'semestre' => '1', 'descripcion' => 'Semestre 2025-1', 'estado' => 'activa', 'created_at' => $now, 'updated_at' => $now],
            ['año' => 2025, 'semestre' => '2', 'descripcion' => 'Semestre 2025-2', 'estado' => 'inactiva', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}