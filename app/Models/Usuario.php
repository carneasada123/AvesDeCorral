<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Cambiado a Authenticatable
use Tymon\JWTAuth\Contracts\JWTSubject;

class Usuario extends Authenticatable implements JWTSubject
{
    protected $table = 'usuarios'; // Tu tabla personalizada
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = ['usuario', 'clave', 'fk_rol', 'fk_estado'];

    // Ocultar la clave para que no se muestre
    protected $hidden = ['clave'];

    // Implementación de JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Mutador para encriptar la contraseña
    public function setClaveAttribute($value)
    {
        $this->attributes['clave'] = bcrypt($value);
    }

    // Relación con la tabla de roles
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'fk_rol');
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'fk_persona');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'fk_estado');
    }
}
