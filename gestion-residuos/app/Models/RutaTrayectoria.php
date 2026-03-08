<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RutaTrayectoria extends Model
{
    protected $table = 'ruta_trayectorias';
    protected $primaryKey = 'id_trayectoria';
    protected $fillable = ['id_ruta', 'latitud', 'longitud', 'orden'];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class, 'id_ruta', 'id_ruta');
    }
}
