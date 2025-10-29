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
            ['numero' => '12', 'tipo' => 'Teórica', 'capacidad' => 40, 'ubicacion' => 'Piso 1', 'modulo_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['numero' => '41', 'tipo' => 'Laboratorio', 'capacidad' => 25, 'ubicacion' => 'Piso 4', 'modulo_id' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}