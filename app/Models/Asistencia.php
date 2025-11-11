<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';

    protected $fillable = [
        'docente_id',
        'grupo_materia_id',
        'horario_id',
        'fecha',
        'hora',
        'estado',
        'observacion',
        'tipo_registro',
        'registrado_por',

        'justificada',
        'motivo_justificacion',
        'aprobado_por',
    ];

    protected $casts = [
        'fecha' => 'date',
        'justificada' => 'boolean',
    ];

    // --- Relaciones ---

    /**
     * Una asistencia pertenece a un Docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class);
    }

    /**
     * Una asistencia está vinculada a un GrupoMateria.
     */
    public function grupoMateria()
    {
        // Asumiendo que ya tienes un modelo GrupoMateria
        return $this->belongsTo(GrupoMateria::class);
    }
    
    /**
     * Una asistencia está vinculada a un Horario (la franja de clase programada).
     */
    public function horario()
    {
        return $this->belongsTo(Horario::class);
    }

    /**
     * El usuario que registró esta asistencia (puede ser un administrador, el mismo docente, etc.)
     */
    public function registrador()
    {
        return $this->belongsTo(\App\Models\User::class, 'registrado_por');
    }

    public function aprobador()
    {
        return $this->belongsTo(\App\Models\User::class, 'aprobado_por');
    }
    // --- Accessors/Mutators ---

    /**
     * Mutator para asegurar que el campo 'fecha' se guarda en el formato correcto (Y-m-d).
     * Nota: Si usas $casts = ['fecha' => 'date'], esto es menos necesario, pero es buena práctica.
     */
    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] = Carbon::parse($value)->format('Y-m-d');
    }

    /**
     * Accessor para capitalizar y mejorar la visualización del estado.
     */
    public function getEstadoDisplayAttribute()
    {
        return ucfirst($this->estado);
    }
}