<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoMateria extends Model
{
    use HasFactory;

    protected $table = 'grupo_materia'; // Nombre explícito de la tabla

    protected $fillable = [
        'materia_id',
        'grupo_id',
        'gestion_id',
        'aula_id',
        'modulo_id',
        'turno',
        'cupo',
        'estado',
    ];

    /**
     * Define la relación: Pertenece a una Materia.
     */
    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Define la relación: Pertenece a un Grupo.
     */
    public function grupo()
    {
        return $this->belongsTo(Grupo::class);
    }

    /**
     * Define la relación: Pertenece a una Gestión.
     */
    public function gestion()
    {
        // Nota: Asegúrate de que tu modelo Gestion se llame 'Gestion' o ajusta esta línea.
        return $this->belongsTo(Gestion::class);
    }

    /**
     * Define la relación opcional: Pertenece a un Aula.
     */
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    /**
     * Define la relación opcional: Pertenece a un Módulo.
     */
    public function modulo()
    {
        return $this->belongsTo(Modulo::class);
    }
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }
}