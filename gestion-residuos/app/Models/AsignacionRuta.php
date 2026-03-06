<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionRuta extends Model
{
    protected $table = 'asignacion_rutas';
    protected $primaryKey = 'id_asignacion_ruta';
    protected $fillable = [
        'id_ruta', 'id_camion', 'id_cuadrilla', 'id_conductor', 
        'id_estado_asignacion_ruta', 'fecha', 'hora_inicio', 'hora_fin',
        'basura_estimada_ton', 'basura_recolectada_ton', 'notas_incidencias'
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta', 'id_ruta');
    }

    public function camion()
    {
        return $this->belongsTo(Camion::class, 'id_camion', 'id_camion');
    }

    public function cuadrilla()
    {
        return $this->belongsTo(Cuadrilla::class, 'id_cuadrilla', 'id_cuadrilla');
    }

    public function conductor()
    {
        return $this->belongsTo(Usuario::class, 'id_conductor', 'id_usuario');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoAsignacionRuta::class, 'id_estado_asignacion_ruta', 'id_estado_asignacion_ruta');
    }
}
