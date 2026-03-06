<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaReciclaje extends Model
{
    protected $table = 'entregas_reciclaje';
    protected $primaryKey = 'id_entrega';
    protected $fillable = [
        'id_punto_verde', 'id_material', 'id_usuario', 
        'cantidad_kg', 'fecha', 'observaciones'
    ];

    public function puntoVerde()
    {
        return $this->belongsTo(PuntoVerde::class, 'id_punto_verde', 'id_punto_verde');
    }

    public function material()
    {
        return $this->belongsTo(Material::class, 'id_material', 'id_material');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}
