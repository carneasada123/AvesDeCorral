<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialStatus extends Model
{
    use HasFactory;

    protected $table = 'material_status';
    protected $primaryKey = 'id_ms';

    // Definir la relación inversa con MaterialCan
    public function materiales()
    {
        return $this->hasMany(MaterialCan::class, 'fk_ms');
    }
}
