<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GruposSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('grupos')->insert([
            ['nombre' => 'SA', 'descripcion' => 'Grupo 1', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'SB', 'descripcion' => 'Grupo 2', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'SC', 'descripcion' => 'Grupo 3', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}