<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    protected $table = 'rutas';
    protected $primaryKey = 'id_ruta';
    protected $fillable = ['id_zona', 'id_tipo_residuo', 'nombre', 'poblacion_estimada', 'distancia_km'];

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

    public function puntosRecoleccion()
    {
        return $this->hasMany(PuntoRecoleccion::class, 'id_ruta', 'id_ruta')->orderBy('posicion_orden');
    }
}
