<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoCamionSeeder extends Seeder
{
    /**
     * Seed the application's database with basic truck statuses.
     */
    public function run(): void
    {
        $estados = [
            ['id_estado_camion' => 1, 'nombre' => 'Operativo', 'descripcion' => 'el camión está en perfectas condiciones para circular'],
            ['id_estado_camion' => 2, 'nombre' => 'En Mantenimiento', 'descripcion' => 'el vehículo está en el taller municipal'],
            ['id_estado_camion' => 3, 'nombre' => 'Fuera de Servicio', 'descripcion' => 'avería grave que impide su uso'],
        ];

        foreach ($estados as $estado) {
            DB::table('estado_camiones')->updateOrInsert(['id_estado_camion' => $estado['id_estado_camion']], $estado);
        }
    }
}
