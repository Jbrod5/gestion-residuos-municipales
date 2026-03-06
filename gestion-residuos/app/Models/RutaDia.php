<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RutaDia extends Model
{
    protected $table = 'ruta_dia';
    protected $primaryKey = 'id_ruta_dia';
    protected $fillable = ['id_ruta', 'id_dia_semana', 'hora_inicio', 'hora_fin'];
}
