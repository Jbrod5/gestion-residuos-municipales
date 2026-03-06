<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contenedor extends Model
{
    protected $table = 'contenedores';
    protected $primaryKey = 'id_contenedor';
    protected $fillable = ['id_punto_verde', 'id_material', 'capacidad_maxima_m3', 'nivel_actual_m3'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }

    public function puntoVerde()
    {
        return $this->belongsTo(PuntoVerde::class, 'id_punto_verde', 'id_punto_verde');
    }
}
