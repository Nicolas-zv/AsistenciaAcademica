<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            // 1. Bandera booleana: Indica si la inasistencia fue formalmente justificada.
            $table->boolean('justificada')->default(false)->after('estado');

            // 2. Texto: Almacena la razón o el motivo de la justificación.
            $table->text('motivo_justificacion')->nullable()->after('justificada');

            // 3. Foreign Key: Almacena el ID del usuario que aprobó la justificación (Administrador/Jefe).
            $table->unsignedBigInteger('aprobado_por')->nullable()->after('motivo_justificacion');
            $table->foreign('aprobado_por')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asistencias', function (Blueprint $table) {
            $table->dropForeign(['aprobado_por']);
            $table->dropColumn(['justificada', 'motivo_justificacion', 'aprobado_por']);
        });
    }
};
