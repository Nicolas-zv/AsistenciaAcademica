<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Nombre de la tabla (opcional si es 'grupos').
     *
     * @var string
     */
    protected $table = 'grupos';

    // Aquí podrías definir relaciones futuras, como:
    /*
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }
    */
}