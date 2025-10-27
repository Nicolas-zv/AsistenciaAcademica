<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            // Relación 0..1 con usuarios (un usuario puede tener 0 o 1 perfil docente)
            $table->unsignedBigInteger('user_id')->nullable()->unique();
            $table->string('codigo')->nullable()->unique();
            $table->date('fecha_contrato')->nullable();
            $table->integer('carga_horaria')->default(0);
            $table->string('especialidad')->nullable();
            $table->string('categoria')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};