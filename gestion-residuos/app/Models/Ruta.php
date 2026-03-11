<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';
    protected $primaryKey = 'id_ruta';
    protected $fillable = [
        'id_zona',
        'id_tipo_residuo',
        'nombre',
        'poblacion_estimada',
        'distancia_km',
        'latitud_inicio',
        'longitud_inicio',
        'latitud_fin',
        'longitud_fin',
        'basura_total_estimada'
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id_zona');
    }

    public function tipoResiduo()
    {
        return $this->belongsTo(TipoResiduo::class, 'id_tipo_residuo', 'id_tipo_residuo');
    }

    public function dias()
    {
        return $this->belongsToMany(DiaSemana::class, 'ruta_dia', 'id_ruta', 'id_dia_semana')
            ->withPivot('hora_inicio', 'hora_fin', 'id_ruta_dia')
            ->withTimestamps();
    }

    public function trayectorias()
    {
        return $this->hasMany(RutaTrayectoria::class, 'id_ruta', 'id_ruta')->orderBy('orden');
    }

    public function puntosRecoleccion()
    {
        return $this->hasMany(PuntoRecoleccion::class, 'id_ruta', 'id_ruta')->orderBy('posicion_orden');
    }

    /**
     * retorna el peso total suma de todos los puntos sembrados municipal
     */
    public function pesoTotalEstimadoKg()
    {
        return $this->puntosRecoleccion->sum('volumen_estimado_kg');
    }

    // app/Models/Ruta.php - Agrega este método
    public function asignaciones()
    {
        return $this->hasMany(AsignacionRuta::class, 'id_ruta', 'id_ruta');
    }
}
