<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';  // Nombre de la tabla

    protected $primaryKey = 'id_persona';  // Definir clave primaria personalizada

    public $timestamps = true;  // Si estás usando los campos created_at y updated_at

    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno'];

    // Si la clave primaria no es autoincremental (pero lo parece), asegúrate de definir su tipo:
    protected $keyType = 'integer';

    // Si tu clave no es autoincremental, define esto como false
    public $incrementing = true;
}
