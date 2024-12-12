<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrega extends Model
{
    protected $table = 'entregas';
    protected $primaryKey = 'id_entrega';

    public $timestamps = false;

    protected $fillable = [
        'fecha_entrega',
    ];
}
