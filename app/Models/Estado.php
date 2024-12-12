<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados'; // Especifica el nombre de la tabla en la base de datos si es diferente del nombre del modelo

    protected $primaryKey = 'id_estado';  // Definir clave primaria personalizada
}
