<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PuntoVerdeHorario extends Model
{
    protected $table = 'punto_verde_horario';
    protected $primaryKey = 'id_punto_verde_horario';
    protected $fillable = [
        'id_punto_verde', 'id_dia_semana', 'hora_inicio', 'hora_fin'
    ];

    public function puntoVerde()
    {
        return $this->belongsTo(PuntoVerde::class, 'id_punto_verde', 'id_punto_verde');
    }

    public function diaSemana()
    {
        return $this->belongsTo(DiaSemana::class, 'id_dia_semana', 'id_dia_semana');
    }
}
