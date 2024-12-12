<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCan extends Model
{
    protected $table = 'materiales_can';
    protected $primaryKey = 'id_mc';

    protected $fillable = ['fk_material', 'cantidad', 'fk_mc', 'fk_ms'];

    public $timestamps = false;

    // Evento para asignar el estado "No entregado" por defecto
    protected static function booted()
    {
        static::creating(function ($materialCan) {
            if (is_null($materialCan->fk_ms)) {
                $materialCan->fk_ms = 1; // Asume que el ID "1" es para "No entregado"
            }
        });
    }

    // Relación con Material
    public function material()
    {
        return $this->belongsTo(Material::class, 'fk_material', 'id_material');
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'fk_servicio', 'id_servicio');
    }

    // Relación con el modelo MaterialStatus
    public function status()
    {
        return $this->belongsTo(MaterialStatus::class, 'fk_ms', 'id_ms');
    }

    // Relacion con serMatCan
    public function serMatCan()
    {
        return $this->hasMany(SerMatCan::class, 'fk_mc', 'id_mc');
    }

    // Relacion con entregaParcialCan
    public function entregasParciales()
    {
        return $this->belongsToMany(EntregaParcialCan::class, 'parcial_mat', 'fk_mc', 'fk_epc');
    }
}
