<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaParcialCan extends Model
{
    use HasFactory;

    protected $table = 'entrega_parcial_can';
    protected $primaryKey = 'id_epc';

    protected $fillable = [
        'cantidad',
        'fk_usuario',
        'comentario',
        'fecha_entrega',
        'recibe',
    ];

    // Relación a través de la tabla intermedia `parcial_mat` con `MaterialCan`
    public function materialesCan()
    {
        return $this->belongsToMany(MaterialCan::class, 'parcial_mat', 'fk_epc', 'fk_mc');
    }

    // Relación con el usuario que realizó la entrega
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'fk_usuario', 'id_usuario');
    }
}
