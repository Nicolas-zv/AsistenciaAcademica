<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $table = 'aulas'; // Nombre explícito de la tabla

    protected $fillable = [
        'numero',
        'tipo',
        'capacidad',
        'ubicacion',
        'modulo_id',
    ];

    /**
     * Define la relación: Un aula pertenece a un Módulo.
     */
    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
}