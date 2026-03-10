<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoDenunciaSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            // estados de ciclo completo de la denuncia
            ['id_estado_denuncia' => 1, 'nombre' => 'Recibida', 'descripcion' => 'Denuncia ingresada y pendiente de revisión'],
            ['id_estado_denuncia' => 2, 'nombre' => 'En Revisión', 'descripcion' => 'Coordinador evaluando la situación reportada'],
            ['id_estado_denuncia' => 3, 'nombre' => 'Asignada', 'descripcion' => 'Cuadrilla seleccionada para atender la denuncia'],
            ['id_estado_denuncia' => 4, 'nombre' => 'En Atención', 'descripcion' => 'Trabajo de limpieza en proceso'],
            ['id_estado_denuncia' => 5, 'nombre' => 'Atendida', 'descripcion' => 'Limpieza completada y documentada'],
            ['id_estado_denuncia' => 6, 'nombre' => 'Cerrada', 'descripcion' => 'Caso finalizado y verificado'],
        ];

        foreach ($estados as $estado) {
            DB::table('estado_denuncias')->updateOrInsert(['id_estado_denuncia' => $estado['id_estado_denuncia']], $estado);
        }
    }
}
