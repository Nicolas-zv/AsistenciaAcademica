<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    use HasFactory;

    protected $table = 'modulos'; // Nombre de la tabla

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'codigo',
    ];

    // Aquí podrías definir relaciones con Materias o Docentes si fuera necesario.
    /*
    public function materias()
    {
        return $this->hasMany(Materia::class);
    }
    */
}