<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;

    protected $table = 'gestion'; // Nombre explícito de la tabla

    protected $fillable = [
        'año',
        'semestre',
        'descripcion',
        'estado',
    ];

    /**
     * Define si una gestión está activa o no.
     */
    const ESTADO_ACTIVA = 'activa';
    const ESTADO_INACTIVA = 'inactiva';

    /**
     * Mutator para asegurar que el año se guarde como entero.
     */
    public function setAñoAttribute($value)
    {
        $this->attributes['año'] = (int) $value;
    }

    /**
     * Mutator para asegurar que el estado se guarde en minúsculas.
     */
    public function setEstadoAttribute($value)
    {
        $this->attributes['estado'] = strtolower($value);
    }
}