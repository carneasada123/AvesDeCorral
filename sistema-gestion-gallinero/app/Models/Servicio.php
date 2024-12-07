<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Importar Str para generar UUID

class Servicio extends Model
{
    protected $table = 'servicios';
    protected $primaryKey = 'id_servicio';

    protected $fillable = ['cct', 'ano', 'fk_trimestre', 'fk_tipo_servicio', 'fk_usuario', 'fk_usuario_editor', 'fk_estado_servicio', 'folio', 'fk_inicio'];

    public $timestamps = true;

    // Evento para generar el folio único antes de crear un nuevo registro
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($servicio) {
            $servicio->folio = Str::uuid(); // Generar un folio único usando un UUID
        });
    }

    // Relación con Trimestre
    public function trimestre()
    {
        return $this->belongsTo(Trimestre::class, 'fk_trimestre', 'id_trimestre');
    }

    // Relación con TipoServicio
    public function tipoServicio()
    {
        return $this->belongsTo(TipoServicio::class, 'fk_tipo_servicio', 'id_servicio');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario', 'id_usuario');
    }

    // Relación con EstadoServicio
    public function estadoServicio()
    {
        return $this->belongsTo(EstadoServicio::class, 'fk_estado_servicio', 'id_estado_servicio');
    }

    public function serMatCan()
    {
        return $this->hasMany(SerMatCan::class, 'fk_servicio', 'id_servicio');
    }

    public function inicio()
    {
        return $this->belongsTo(Inicio::class, 'fk_inicio', 'id_inicio');
    }

    // public function entrega()
    // {
    //     return $this->belongsTo(Entrega::class, 'fk_entrega', 'id_entrega');
    // }

    public function usuarioEditor()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario_editor', 'id_usuario');
    }
}
