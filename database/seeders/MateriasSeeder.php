<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MateriasSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('materias')->insert([
            ['nombre' => 'Introducción a la Programación', 'sigla' => 'INF110', 'descripcion' => 'Fundamentos', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Estructuras de Datos', 'sigla' => 'INF220', 'descripcion' => 'Listas, pilas, colas', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Bases de Datos I', 'sigla' => 'INF312', 'descripcion' => 'Relacionales y SQL', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}