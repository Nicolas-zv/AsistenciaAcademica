<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AulasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // modul_id 1 y 2
        DB::table('aulas')->insert([
            ['numero' => 'A101', 'tipo' => 'Teórica', 'capacidad' => 40, 'ubicacion' => 'Piso 1', 'modulo_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['numero' => 'B201', 'tipo' => 'Laboratorio', 'capacidad' => 25, 'ubicacion' => 'Piso 2', 'modulo_id' => 2, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}