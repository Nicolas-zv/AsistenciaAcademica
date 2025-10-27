<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // orden importante según dependencias
        $this->call([
            RolesSeeder::class,
            PermisosSeeder::class,
            RolPermisosSeeder::class,
            UsersSeeder::class,
            DocentesSeeder::class,
            MateriasSeeder::class,
            GruposSeeder::class,
            GestionSeeder::class,
            ModulosSeeder::class,
            AulasSeeder::class,
            GrupoMateriaSeeder::class,
            HorariosSeeder::class,
            AsistenciasSeeder::class,
        ]);
    }
}
