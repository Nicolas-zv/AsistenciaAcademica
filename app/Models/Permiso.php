<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Permiso extends Model
{
    use HasFactory;
    
    // Si la tabla no se llamara 'permisos', usarías protected $table = 'nombre_tabla';
    // Pero asumo que Laravel infiere correctamente el nombre 'permisos'.

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // NOTA: Aquí iría la relación con la tabla pivot 'role_permiso' si la implementas,
    // para indicar qué roles tienen este permiso.
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            Role::class,       // Modelo de destino
            'rol_permisos',    // Nombre de la tabla pivot
            'permiso_id',      // Clave foránea local en la tabla pivot (por defecto sería 'permiso_id')
            'role_id'          // Clave foránea del modelo de destino en la tabla pivot (por defecto sería 'role_id')
        );
    }
}