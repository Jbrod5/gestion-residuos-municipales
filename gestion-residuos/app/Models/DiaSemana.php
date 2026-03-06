<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    protected $table = 'dias_semana';
    protected $primaryKey = 'id_dia_semana';
    protected $fillable = ['nombre'];
}
