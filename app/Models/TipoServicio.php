<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoServicio extends Model
{
    protected $table = 'tipos_servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = ['descripcion'];

    public $timestamps = false;
}
