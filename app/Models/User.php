<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- NUEVO: Importar Attribute

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $primaryKey = 'correo';
    public $incrementing = false;
    protected $keyType = 'string';
    // ... (protected $fillable y el resto de propiedades quedan igual)
    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'telefono',
        'role_id',
        'activo',
    ];
    // ...
    public function getAuthIdentifierName()
    {
        // Esto le dice a Laravel (y a la base de datos) que use la columna 'correo'
        // para buscar al usuario durante el proceso de login.
        return 'correo';
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    // ... (protected $hidden y protected function casts() quedan igual)

    public function docente(): HasOne
    {
       return $this->hasOne(Docente::class, 'user_id', 'correo');
    }

    /**
     * Define un accessor para la propiedad virtual 'email'.
     * Esto asegura la compatibilidad con Laravel Breeze y Auth::validate().
     */
    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->correo,
        );
    }
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->nombre);

        $initials = '';
        foreach ($words as $word) {
            // Solo toma la primera letra de las dos primeras palabras, si existen
            if (strlen($initials) < 2 && !empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }

        // Si el nombre es muy corto (ej: "Ana"), aseguramos que al menos haya una inicial.
        return $initials ?: strtoupper(substr($this->nombre, 0, 1));
    }
}
