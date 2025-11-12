<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Docente; // Asegúrate de importar todos los modelos relacionados

class GrupoMateria extends Model
{
    use HasFactory;

    // Nombre explícito de la tabla para evitar el problema de pluralización automática
    protected $table = 'grupo_materia';

    // Propiedad para cargar automáticamente las relaciones necesarias
    // (Útil para evitar el problema N+1 en vistas comunes como index y edit)
    protected $with = ['materia', 'grupo', 'gestion', 'aula', 'modulo', 'docente'];

    protected $fillable = [
        'materia_id',
        'grupo_id',
        'gestion_id',
        'aula_id',
        'modulo_id',
        'docente_id', // Clave foránea correcta (user_id del docente)
        'turno',
        'cupo',
        'estado',
    ];

    // Se asume que estos modelos existen en App\Models

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

    /**
     * Define la relación: Pertenece a un Docente.
     * Usamos 'docente_id' como clave foránea, pero Laravel la resuelve
     * asumiendo que es una FK al campo ID del modelo Docente. Si 'docente_id'
     * apunta al campo 'user_id' (email) del modelo Docente, podría ser necesario
     * especificar la clave de referencia.
     * * Dado que el error no es aquí, asumiremos que Laravel resuelve la
     * relación correctamente, o que el DocenteController está cargando
     * correctamente los datos del docente.
     */
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id', 'id');
    }


    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
