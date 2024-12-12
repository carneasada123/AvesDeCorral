<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trimestre extends Model
{
    protected $table = 'trimestres';
    protected $primaryKey = 'id_trimestre';

    // Definir los campos que son asignables masivamente
    protected $fillable = ['descripcion'];

    public $timestamps = false; // Si no usas timestamps
}
