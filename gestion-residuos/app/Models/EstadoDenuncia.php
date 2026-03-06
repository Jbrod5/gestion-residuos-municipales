<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoDenuncia extends Model
{
    protected $table = 'estado_denuncias';
    protected $primaryKey = 'id_estado_denuncia';
    protected $fillable = ['nombre', 'descripcion'];
}
