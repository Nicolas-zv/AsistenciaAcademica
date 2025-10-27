<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolPermisosSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // role_id 1=admin -> todos los permisos (asumiendo el orden del seeder PermisosSeeder)
        DB::table('rol_permisos')->insert([
            ['role_id' => 1, 'permiso_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['role_id' => 1, 'permiso_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['role_id' => 1, 'permiso_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['role_id' => 1, 'permiso_id' => 4, 'created_at' => $now, 'updated_at' => $now],

            // coordinador (role_id = 2) -> asignar + ver
            ['role_id' => 2, 'permiso_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['role_id' => 2, 'permiso_id' => 2, 'created_at' => $now, 'updated_at' => $now],

            // docente (role_id = 3) -> ver + registrar asistencia
            ['role_id' => 3, 'permiso_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['role_id' => 3, 'permiso_id' => 3, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}