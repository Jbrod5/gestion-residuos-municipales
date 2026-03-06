<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TamanoDenuncia extends Model
{
    protected $table = 'tamanos_denuncia';
    protected $primaryKey = 'id_tamano_denuncia';
    protected $fillable = ['nombre', 'descripcion'];
}
