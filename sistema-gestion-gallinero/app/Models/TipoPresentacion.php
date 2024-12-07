<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPresentacion extends Model
{
    protected $table = 'tipos_presentacion';
    protected $primaryKey = 'id_tp';

    protected $fillable = ['descripcion'];

    public $timestamps = false;
}
