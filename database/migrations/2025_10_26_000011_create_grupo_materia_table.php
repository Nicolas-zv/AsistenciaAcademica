<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grupo_materia', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relaciones
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('gestion_id');

            // 👇 CAMBIO CLAVE: docente_id numérico (coherente con docentes.id)
            $table->unsignedBigInteger('docente_id')->nullable();

            // Opcionales
            $table->unsignedBigInteger('aula_id')->nullable();
            $table->unsignedBigInteger('modulo_id')->nullable();

            // Info adicional
            $table->string('turno')->nullable();
            $table->integer('cupo')->nullable();
            $table->string('estado')->default('activo');

            $table->timestamps();

            // Relaciones foráneas
            $table->foreign('materia_id')->references('id')->on('materias')->cascadeOnDelete();
            $table->foreign('grupo_id')->references('id')->on('grupos')->cascadeOnDelete();
            $table->foreign('gestion_id')->references('id')->on('gestion')->cascadeOnDelete();
            $table->foreign('aula_id')->references('id')->on('aulas')->nullOnDelete();
            $table->foreign('modulo_id')->references('id')->on('modulos')->nullOnDelete();

            // 👇 Ahora referencia a docentes.id (entero)
            $table->foreign('docente_id')
                ->references('id')
                ->on('docentes')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->unique(['materia_id', 'grupo_id', 'gestion_id'], 'idx_grupo_materia_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_materia');
    }
};
