<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionDenuncia extends Model
{
    protected $table = 'asignacion_denuncias';
    protected $primaryKey = 'id_asignacion_denuncia';
    protected $fillable = ['id_denuncia', 'id_cuadrilla', 'fecha_asignacion', 'fecha_atencion'];

    public function denuncia()
    {
        return $this->belongsTo(Denuncia::class, 'id_denuncia', 'id_denuncia');
    }

    public function cuadrilla()
    {
        return $this->belongsTo(Cuadrilla::class, 'id_cuadrilla', 'id_cuadrilla');
    }
}
