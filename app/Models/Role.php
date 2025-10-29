<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Nota: Asegúrate de que el modelo de permisos se llame 'Permission' 
//       o 'Permiso' y que exista. Usaremos 'Permission::class' para estandarizar
//       siguiendo las convenciones de nomenclatura en inglés, pero adaptaremos
//       la tabla y las claves foráneas.

class Role extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    // Relación: Un Rol tiene muchos Usuarios
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
    
    /**
     * Un Rol tiene muchos Permisos (Relación Muchos a Muchos con tabla pivot)
     * SOLUCION: Se especifican las claves foráneas exactas de tu tabla 'rol_permisos'.
     */
    public function permissions(): BelongsToMany
    {
        // belongsToMany(ModeloRelacionado, tabla_pivote, clave_local, clave_remota)
        return $this->belongsToMany(
            Permission::class, // <-- Modelo de Permisos (debe existir en App/Models)
            'rol_permisos',    // <-- Nombre de la tabla pivote
            'role_id',          // <-- CLAVE FORÁNEA DEL ROL EN LA PIVOTE (Asumiendo que es rol_id)
            'permiso_id'       // <-- CLAVE FORÁNEA DEL PERMISO EN LA PIVOTE (Asumiendo que es permiso_id)
        );
    }
}