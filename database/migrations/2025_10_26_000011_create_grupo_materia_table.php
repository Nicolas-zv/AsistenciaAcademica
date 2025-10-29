<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grupo_materia', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relaciones 1..* con materias, grupos y gestion (estas están bien con ID numérico)
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('gestion_id');
            
            // 🛑 CRÍTICO: CAMBIO 1 - Convertir docente_id a STRING
            // Debe ser STRING para almacenar el CORREO (que viene de docentes.user_id)
            $table->string('docente_id')->nullable();

            // Opcionales: aula y modulo asignados
            $table->unsignedBigInteger('aula_id')->nullable();
            $table->unsignedBigInteger('modulo_id')->nullable();

            // Información adicional
            $table->string('turno')->nullable();
            $table->integer('cupo')->nullable();
            $table->string('estado')->default('activo');

            $table->timestamps();

            // Claves foráneas numéricas (Estas están correctas)
            $table->foreign('materia_id')->references('id')->on('materias')->cascadeOnDelete();
            $table->foreign('grupo_id')->references('id')->on('grupos')->cascadeOnDelete();
            $table->foreign('gestion_id')->references('id')->on('gestion')->cascadeOnDelete();
            $table->foreign('aula_id')->references('id')->on('aulas')->nullOnDelete();
            $table->foreign('modulo_id')->references('id')->on('modulos')->nullOnDelete();
            
            // 🛑 CRÍTICO: CAMBIO 2 - Referenciar la columna 'user_id' de la tabla 'docentes'
            $table->foreign('docente_id')
                  ->references('user_id') // <-- ¡Apunta a 'user_id' de docentes, que ahora es STRING!
                  ->on('docentes')
                  ->onUpdate('cascade')
                  ->onDelete('set null'); // Usar 'set null' para permitir grupos sin docente si el perfil se elimina

            $table->unique(['materia_id','grupo_id','gestion_id'], 'idx_grupo_materia_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_materia');
    }
};