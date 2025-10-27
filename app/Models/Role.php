<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(
            Permiso::class,    // Modelo de destino
            'rol_permisos',    // Nombre de la tabla pivot
            'role_id',         // Clave foránea local en la tabla pivot
            'permiso_id'       // Clave foránea del modelo de destino en la tabla pivot
        );
    }
}