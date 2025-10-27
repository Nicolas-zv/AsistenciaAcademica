<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;
    
    // Si tu clave primaria se llama 'id' y es autoincremental, no necesitas estas líneas.
    // protected $primaryKey = 'id';
    // public $incrementing = true;
    
    protected $fillable = [
        'nombre',
        'sigla',
        'descripcion',
    ];
}