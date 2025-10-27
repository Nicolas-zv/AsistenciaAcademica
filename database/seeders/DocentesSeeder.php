<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocentesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // Asumimos usuarios insertados; Ana (id=3) y Juan (id=4)
        DB::table('docentes')->insert([
            ['user_id' => 3, 'codigo' => 'DOC-001', 'fecha_contrato' => '2024-03-01', 'carga_horaria' => 8, 'especialidad' => 'Sistemas', 'categoria' => 'Titular', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => 4, 'codigo' => 'DOC-002', 'fecha_contrato' => '2023-08-15', 'carga_horaria' => 6, 'especialidad' => 'Bases de datos', 'categoria' => 'Contratista', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}