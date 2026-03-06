<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoRecoleccion extends Model
{
    protected $table = 'puntos_recoleccion';
    protected $primaryKey = 'id_punto_recoleccion';
    protected $fillable = ['id_ruta', 'posicion_orden', 'latitud', 'longitud'];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta', 'id_ruta');
    }
}
