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
            ['nombre' => 'Bloque A', 'codigo' => 'A', 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Bloque B', 'codigo' => 'B', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}