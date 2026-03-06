<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCamion extends Model
{
    protected $table = 'estado_camiones';
    protected $primaryKey = 'id_estado_camion';
    protected $fillable = ['nombre', 'descripcion'];
}
