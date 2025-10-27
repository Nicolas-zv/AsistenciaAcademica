<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $fillable = [
        'grupo_materia_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'modalidad',
        'estado',
    ];

    /**
     * Define la relación: Un horario pertenece a un GrupoMateria.
     */
    public function grupoMateria()
    {
        // Asegúrate de que el nombre del modelo coincida
        return $this->belongsTo(GrupoMateria::class);
    }

    /**
     * Accessor para obtener el nombre del día de la semana.
     */
    public function getDiaNombreAttribute()
    {
        $dias = [
            0 => 'Domingo',
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
        ];

        return $dias[$this->dia] ?? 'Día Desconocido';
    }
}