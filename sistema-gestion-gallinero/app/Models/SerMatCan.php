<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SerMatCan extends Model
{
    protected $table = 'ser_mat_can';
    protected $primaryKey = 'id_smc';

    protected $fillable = ['fk_servicio', 'fk_mc'];

    public $timestamps = false;

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'fk_servicio', 'id_servicio');
    }

    // Relación con MaterialCan
    public function materialCan()
    {
        return $this->belongsTo(MaterialCan::class, 'fk_mc', 'id_mc');
    }
}

// class MaterialCan extends Model
// {
//     protected $table = 'materiales_can';
//     protected $primaryKey = 'id_mc';

//     public function material()
//     {
//         return $this->belongsTo(Material::class, 'fk_material');
//     }
// }
