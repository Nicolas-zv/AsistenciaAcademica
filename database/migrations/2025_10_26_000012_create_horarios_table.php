<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('grupo_materia_id');
            $table->tinyInteger('dia')->comment('0=domingo,1=lunes...6=sabado');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('modalidad')->nullable();
            $table->string('estado')->default('programado');
            $table->timestamps();

            $table->foreign('grupo_materia_id')->references('id')->on('grupo_materia')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};