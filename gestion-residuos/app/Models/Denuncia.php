<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'denuncias';
    protected $primaryKey = 'id_denuncia';
    protected $fillable = [
        'id_usuario', 
        'id_estado_denuncia', 
        'id_tamano_denuncia', 
        'descripcion', 
        'fecha', 
        'foto_antes', 
        'foto_despues', 
        'latitud', 
        'longitud'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function estado()
    {
        return $this->belongsTo(EstadoDenuncia::class, 'id_estado_denuncia', 'id_estado_denuncia');
    }

    public function tamano()
    {
        return $this->belongsTo(TamanoDenuncia::class, 'id_tamano_denuncia', 'id_tamano_denuncia');
    }
}
