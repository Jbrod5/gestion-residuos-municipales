<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    protected $table = 'camiones';
    protected $primaryKey = 'id_camion';
    protected $fillable = ['id_estado_camion', 'placa', 'capacidad_toneladas'];
}
