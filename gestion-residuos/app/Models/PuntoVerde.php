<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoVerde extends Model
{
    protected $table = 'puntos_verde';
    protected $primaryKey = 'id_punto_verde';
    protected $fillable = [
        'id_encargado', 'nombre', 'direccion', 'horario', 
        'capacidad_total_m3', 'latitud', 'longitud'
    ];

    public function encargado()
    {
        return $this->belongsTo(Usuario::class, 'id_encargado', 'id_usuario');
    }

    public function contenedores()
    {
        return $this->hasMany(Contenedor::class, 'id_punto_verde', 'id_punto_verde');
    }

    public function horarios()
    {
        return $this->hasMany(PuntoVerdeHorario::class, 'id_punto_verde', 'id_punto_verde');
    }
}
