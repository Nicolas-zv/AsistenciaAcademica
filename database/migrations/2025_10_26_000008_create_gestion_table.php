<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gestion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('año');
            $table->string('semestre')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('estado')->default('inactiva');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gestion');
    }
};