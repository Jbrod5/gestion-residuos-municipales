<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zonas';
    protected $primaryKey = 'id_zona';
    protected $fillable = ['id_tipo_zona', 'nombre', 'latitud', 'longitud'];

    public function tipoZona()
    {
        return $this->belongsTo(TipoZona::class, 'id_tipo_zona', 'id_tipo_zona');
    }

    public function rutas()
    {
        return $this->hasMany(Ruta::class, 'id_zona', 'id_zona');
    }

    public function cuadrillas()
    {
        return $this->hasMany(Cuadrilla::class, 'id_zona', 'id_zona');
    }
}
