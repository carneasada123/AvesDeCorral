<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';
    protected $primaryKey = 'id_material';

    protected $fillable = ['codigo', 'descripcion', 'fk_tp'];

    public $timestamps = false;

    // Relación con tipos_presentacion
    public function tipoPresentacion()
    {
        return $this->belongsTo(TipoPresentacion::class, 'fk_tp', 'id_tp');
    }

    // Relación con materialesCan
    public function materialesCan()
    {
        return $this->hasMany(MaterialCan::class, 'fk_material', 'id_material');
    }

}
