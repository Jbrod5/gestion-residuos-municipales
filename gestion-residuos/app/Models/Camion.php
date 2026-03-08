<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Camion extends Model
{
    protected $table = 'camiones';
    protected $primaryKey = 'id_camion';
    protected $fillable = ['id_estado_camion', 'placa', 'capacidad_toneladas'];

    public function estado()
    {
        return $this->belongsTo(EstadoCamion::class, 'id_estado_camion', 'id_estado_camion');
    }

    public function cuadrilla()
    {
        return $this->hasOne(Cuadrilla::class, 'id_camion', 'id_camion');
    }

    public function asignaciones()
    {
        return $this->hasMany(AsignacionRuta::class, 'id_camion', 'id_camion');
    }
}
