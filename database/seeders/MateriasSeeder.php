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
            ['nombre' => 'Introducción a la Programación', 'sigla' => 'MAT101', 'descripcion' => 'Fundamentos', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Estructuras de Datos', 'sigla' => 'MAT102', 'descripcion' => 'Listas, pilas, colas', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Bases de Datos', 'sigla' => 'MAT201', 'descripcion' => 'Relacionales y SQL', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}