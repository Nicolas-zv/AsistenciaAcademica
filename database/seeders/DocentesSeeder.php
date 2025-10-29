<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Importar el modelo User
use Carbon\Carbon;

class DocentesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 🚀 CRÍTICO: Buscar por CORREO EXACTO, no por nombre parcial
        $correo_ana = User::where('correo', 'ana.perez@ficct.edu')->value('correo');
        $correo_juan = User::where('correo', 'juan.gomez@ficct.edu')->value('correo');
        
        if (!$correo_ana || !$correo_juan) {
            $this->command->error('No se pudieron encontrar los correos de Ana o Juan. Verifique UsersSeeder y el correo exacto.');
            return; 
        }

        DB::table('docentes')->insert([
            // La clave 'user_id' es el CORREO
            ['user_id' => $correo_ana, 'codigo' => 'DOC-001', 'fecha_contrato' => '2024-03-01', 'carga_horaria' => 8, 'especialidad' => 'Sistemas', 'categoria' => 'Titular', 'created_at' => $now, 'updated_at' => $now],
            ['user_id' => $correo_juan, 'codigo' => 'DOC-002', 'fecha_contrato' => '2023-08-15', 'carga_horaria' => 6, 'especialidad' => 'Bases de datos', 'categoria' => 'Contratista', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}