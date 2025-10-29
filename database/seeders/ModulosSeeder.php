<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ModulosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('modulos')->insert([
            ['nombre' => 'Facultad de Ingeniería en Ciencias de la Comunicacion y telecomunicaciones', 'codigo' => '236', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}