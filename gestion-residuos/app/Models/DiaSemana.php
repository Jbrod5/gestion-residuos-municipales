<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    protected $table = 'dias_semana'; // Nombre de la tabla
    protected $primaryKey = 'id_dia_semana'; //llave primaria personalizada
    
    // Importante para que updateOrCreate funcione con estos campos
    protected $fillable = ['id_dia_semana', 'nombre']; 
}