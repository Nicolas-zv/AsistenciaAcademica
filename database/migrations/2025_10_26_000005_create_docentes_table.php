<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            // 🛑 CRÍTICO: CAMBIO 1 - Usar STRING en lugar de unsignedBigInteger
            // Debe ser de tipo STRING para almacenar el correo electrónico.
            $table->string('user_id')->unique(); 
            
            $table->string('codigo')->nullable()->unique();
            $table->date('fecha_contrato')->nullable();
            $table->integer('carga_horaria')->default(0);
            $table->string('especialidad')->nullable();
            $table->string('categoria')->nullable();
            $table->timestamps();

            // 🛑 CRÍTICO: CAMBIO 2 - Referenciar la columna 'correo' de la tabla 'users'
            $table->foreign('user_id')
                  ->references('correo') // <-- ¡Apunta a 'correo', no a 'id'!
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict'); // Mejor usar 'restrict' o 'nullify' para evitar borrar el usuario completo
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};