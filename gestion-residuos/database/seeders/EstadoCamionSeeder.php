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
        DB::table('estado_camiones')->insert([
            ['nombre' => 'Operativo', 'descripcion' => 'el camión está en perfectas condiciones para circular'],
            ['nombre' => 'En Mantenimiento', 'descripcion' => 'el vehículo está en el taller municipal'],
            ['nombre' => 'Fuera de Servicio', 'descripcion' => 'avería grave que impide su uso'],
        ]);
    }
}
