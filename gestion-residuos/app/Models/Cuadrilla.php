<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuadrilla extends Model
{
    protected $table = 'cuadrillas';
    protected $primaryKey = 'id_cuadrilla';
    protected $fillable = ['nombre', 'disponible'];

    public function trabajadores()
    {
        return $this->belongsToMany(Usuario::class, 'cuadrilla_trabajador', 'id_cuadrilla', 'id_usuario')
                    ->withTimestamps();
    }
}
