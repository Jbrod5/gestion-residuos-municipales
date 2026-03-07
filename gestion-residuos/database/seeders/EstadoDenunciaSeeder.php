<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoDenunciaSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            ['id_estado_denuncia' => 1, 'nombre' => 'Pendiente', 'descripcion' => 'Denuncia recibida y esperando revisión'],
            ['id_estado_denuncia' => 2, 'nombre' => 'En Revisión', 'descripcion' => 'Un coordinador está evaluando la denuncia'],
            ['id_estado_denuncia' => 3, 'nombre' => 'Atendida', 'descripcion' => 'La limpieza del basurero ha sido completada'],
            ['id_estado_denuncia' => 4, 'nombre' => 'En Proceso', 'descripcion' => 'Una cuadrilla ha sido asignada y está en camino'],
        ];

        foreach ($estados as $estado) {
            DB::table('estado_denuncias')->updateOrInsert(['id_estado_denuncia' => $estado['id_estado_denuncia']], $estado);
        }
    }
}
