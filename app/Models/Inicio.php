<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inicio extends Model
{
    protected $table = 'inicios';
    protected $primaryKey = 'id_inicio';

    public $timestamps = false;

    protected $fillable = [
        'fecha_inicio',
    ];
}
