<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcialMat extends Model
{
    use HasFactory;

    protected $table = 'parcial_mat';
    protected $primaryKey = 'id_parcial_mat';
    public $timestamps = false;

    protected $fillable = [
        'fk_epc',
        'fk_mc',
    ];

    public function entregaParcialCan()
    {
        return $this->belongsTo(EntregaParcialCan::class, 'fk_epc');
    }

    public function materialCan()
    {
        return $this->belongsTo(MaterialCan::class, 'fk_mc');
    }
}
