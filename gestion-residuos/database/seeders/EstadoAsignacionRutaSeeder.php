<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoAsignacionRutaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['id_estado_asignacion_ruta' => 1, 'nombre' => 'Programada', 'color' => 'info'],
            ['id_estado_asignacion_ruta' => 2, 'nombre' => 'En Curso', 'color' => 'warning'],
            ['id_estado_asignacion_ruta' => 3, 'nombre' => 'Completada', 'color' => 'success'],
            ['id_estado_asignacion_ruta' => 4, 'nombre' => 'Cancelada', 'color' => 'danger'],
        ];

        foreach ($estados as $estado) {
            DB::table('estado_asignacion_rutas')->updateOrInsert(
                ['id_estado_asignacion_ruta' => $estado['id_estado_asignacion_ruta']],
                ['nombre' => $estado['nombre'], 'color' => $estado['color']]
            );
        }
    }
}
