<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoResiduo extends Model
{
    protected $table = 'tipo_residuos';
    protected $primaryKey = 'id_tipo_residuo';
    protected $fillable = ['nombre', 'descripcion'];
}
