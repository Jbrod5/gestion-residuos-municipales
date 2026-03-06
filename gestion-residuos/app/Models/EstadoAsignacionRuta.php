<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoAsignacionRuta extends Model
{
    protected $table = 'estado_asignacion_rutas';
    protected $primaryKey = 'id_estado_asignacion_ruta';
    protected $fillable = ['nombre', 'descripcion'];
}
