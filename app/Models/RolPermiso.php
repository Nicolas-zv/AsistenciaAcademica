<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

// Se recomienda extender Pivot en lugar de Model para tablas intermedias
class RolPermiso extends Pivot
{
    use HasFactory;

    // Nombre explícito de la tabla
    protected $table = 'rol_permisos';

    // Campos que puedes asignar masivamente
    protected $fillable = [
        'role_id',
        'permiso_id',
    ];

    // Por defecto, las clases Pivot asumen que no tienen una clave primaria autoincremental.
    // Como tu esquema sí la tiene, es buena práctica indicarlo:
    public $incrementing = true;
}