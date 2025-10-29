<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // ⚠️ AÑADIDO: Importar Attribute

class Docente extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'codigo',
        'fecha_contrato',
        'carga_horaria',
        'especialidad',
        'categoria',
    ];

    protected $casts = [
        'fecha_contrato' => 'date',
    ];

    /**
     * Un Docente pertenece a un Usuario (Relación One-to-One Inversa).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'correo');
    }

    // ⚠️ AÑADIDO: ACCESOR PARA OBTENER EL NOMBRE DEL DOCENTE DEL MODELO USER
    protected function nombreCompleto(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->user->nombre ?? 'Docente no Asignado',
        );
    }
    // Accesor para obtener el correo del usuario (user_id contiene el correo)
    protected function userCorreo(): Attribute
    {
        return Attribute::make(
            // Nota: find($this->user_id) funciona porque tu PK de User es 'correo'.
            get: fn () => User::find($this->user_id)->correo ?? null,
        );
    }
}