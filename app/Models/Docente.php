<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsTo(User::class);
    }
}