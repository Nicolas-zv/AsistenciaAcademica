<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grupo_materia', function (Blueprint $table) {
            $table->bigIncrements('id');

            // Relaciones 1..* con materias, grupos y gestion según diagrama
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('gestion_id');

            // Opcionales: aula y modulo asignados (pueden cambiar)
            $table->unsignedBigInteger('aula_id')->nullable();
            $table->unsignedBigInteger('modulo_id')->nullable();

            // Información adicional
            $table->string('turno')->nullable();
            $table->integer('cupo')->nullable();
            $table->string('estado')->default('activo');

            $table->timestamps();

            $table->foreign('materia_id')->references('id')->on('materias')->cascadeOnDelete();
            $table->foreign('grupo_id')->references('id')->on('grupos')->cascadeOnDelete();
            $table->foreign('gestion_id')->references('id')->on('gestion')->cascadeOnDelete();
            $table->foreign('aula_id')->references('id')->on('aulas')->nullOnDelete();
            $table->foreign('modulo_id')->references('id')->on('modulos')->nullOnDelete();
            $table->unique(['materia_id','grupo_id','gestion_id'], 'idx_grupo_materia_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_materia');
    }
};