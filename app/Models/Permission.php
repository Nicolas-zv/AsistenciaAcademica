<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Role; // Importar el modelo Role para la relación
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Permission extends Model
{
    use HasFactory;

    /**
     * Define el nombre de la tabla de la base de datos (si es diferente a la convención plural).
     * En tu caso, es 'permisos'.
     *
     * @var string
     */
    protected $table = 'permisos';

    /**
     * Define la relación Many-to-Many con el modelo Role.
     * Esta relación usa la tabla pivote 'rol_permisos'.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
  public function roles(): BelongsToMany
    {
        // belongsToMany(ModeloRelacionado, tabla_pivote, clave_local, clave_remota)
        return $this->belongsToMany(
            Role::class, 
            'rol_permisos',    // El nombre de tu tabla pivote
            'permiso_id',      // Clave foránea del Permission (¡Coincide con la migración!)
            'role_id'          // Clave foránea del Role
        );
    }
    // Opcional: Si tienes campos 'nombre' y 'descripcion', podrías usar $fillable
    // protected $fillable = ['nombre', 'descripcion'];
}