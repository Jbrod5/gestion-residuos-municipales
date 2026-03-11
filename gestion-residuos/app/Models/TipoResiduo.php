<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoResiduo extends Model
{
    protected $table = 'tipo_residuos';
    protected $primaryKey = 'id_tipo_residuo';
    protected $fillable = ['nombre', 'descripcion'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    public function rutas()
    {
        return $this->hasMany(Ruta::class, 'id_tipo_residuo', 'id_tipo_residuo');
    }

    public function getFechaCreacionAttribute()
{
    return $this->created_at ? $this->created_at->format('d/m/Y') : '—';
}
}
