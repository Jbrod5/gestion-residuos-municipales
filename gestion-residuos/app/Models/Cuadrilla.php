<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuadrilla extends Model
{
    protected $table = 'cuadrillas';
    protected $primaryKey = 'id_cuadrilla';
    protected $fillable = ['nombre', 'disponible', 'id_camion', 'id_zona'];

    public function camion()
    {
        return $this->belongsTo(Camion::class, 'id_camion', 'id_camion');
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id_zona');
    }

    public function trabajadores()
    {
        return $this->belongsToMany(Usuario::class, 'cuadrilla_trabajador', 'id_cuadrilla', 'id_usuario')
                    ->withTimestamps();
    }
}
