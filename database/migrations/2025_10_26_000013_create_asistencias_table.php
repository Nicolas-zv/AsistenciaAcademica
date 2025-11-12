<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
         Schema::create('asistencias', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('docente_id');
            $table->unsignedBigInteger('grupo_materia_id')->nullable();
            $table->unsignedBigInteger('horario_id')->nullable();

            $table->date('fecha');
            $table->time('hora')->nullable();
            $table->enum('estado', ['presente', 'ausente', 'tarde'])->default('presente');
            $table->text('observacion')->nullable();
            $table->string('tipo_registro')->nullable();
            $table->unsignedBigInteger('registrado_por')->nullable();
            $table->timestamps();

            $table->foreign('docente_id')->references('id')->on('docentes')->cascadeOnDelete();
            $table->foreign('grupo_materia_id')->references('id')->on('grupo_materia')->nullOnDelete();
            $table->foreign('horario_id')->references('id')->on('horarios')->nullOnDelete();
            $table->foreign('registrado_por')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
