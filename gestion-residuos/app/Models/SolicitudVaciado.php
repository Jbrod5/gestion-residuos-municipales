<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudVaciado extends Model
{
    protected $table = 'solicitudes_vaciado';
    protected $primaryKey = 'id_solicitud';
    protected $fillable = [
        'id_punto_verde',
        'id_contenedor',
        'id_usuario',
        'estado',
        'volumen_m3',
        'fecha_solicitud',
        'fecha_atencion',
    ];

    public function puntoVerde()
    {
        return $this->belongsTo(PuntoVerde::class, 'id_punto_verde', 'id_punto_verde');
    }

    public function contenedor()
    {
        return $this->belongsTo(Contenedor::class, 'id_contenedor', 'id_contenedor');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
