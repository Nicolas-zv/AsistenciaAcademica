<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            ['nombre' => 'Administrador FICCT', 'correo' => 'admin@ficct.edu', 'password' => Hash::make('password'), 'telefono' => '000000000', 'role_id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Coordinador', 'correo' => 'coordinador@ficct.edu', 'password' => Hash::make('password'), 'telefono' => '111111111', 'role_id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Ana Pérez', 'correo' => 'ana.perez@ficct.edu', 'password' => Hash::make('password'), 'telefono' => '222222222', 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Juan Gómez', 'correo' => 'juan.gomez@ficct.edu', 'password' => Hash::make('password'), 'telefono' => '333333333', 'role_id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Secretaria', 'correo' => 'secretaria@ficct.edu', 'password' => Hash::make('password'), 'telefono' => '444444444', 'role_id' => 4, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}