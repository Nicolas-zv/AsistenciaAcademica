<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('aulas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero')->nullable();
            $table->string('tipo')->nullable();
            $table->integer('capacidad')->nullable();
            $table->string('ubicacion')->nullable();
            $table->unsignedBigInteger('modulo_id')->nullable();
            $table->timestamps();

            $table->foreign('modulo_id')->references('id')->on('modulos')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aulas');
    }
};