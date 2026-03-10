<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaSeeder extends Seeder
{
    /**
     * Seed para zonas
     */
    public function run(): void
    {
        $zonas = [
            ['id_zona' => 1, 'id_tipo_zona' => 1, 'nombre' => 'Zona 1 Centro Histórico', 'latitud' => 14.8400, 'longitud' => -91.5200, 'created_at' => now(), 'updated_at' => now()],
            ['id_zona' => 2, 'id_tipo_zona' => 1, 'nombre' => 'Zona 2 El Calvario', 'latitud' => 14.8380, 'longitud' => -91.5170, 'created_at' => now(), 'updated_at' => now()],
            ['id_zona' => 3, 'id_tipo_zona' => 1, 'nombre' => 'Zona 3 Minerva', 'latitud' => 14.8455, 'longitud' => -91.5195, 'created_at' => now(), 'updated_at' => now()],
            ['id_zona' => 4, 'id_tipo_zona' => 1, 'nombre' => 'Zona 4 Las Américas', 'latitud' => 14.8465, 'longitud' => -91.5310, 'created_at' => now(), 'updated_at' => now()],
            ['id_zona' => 5, 'id_tipo_zona' => 1, 'nombre' => 'Zona 5 La Floresta', 'latitud' => 14.8365, 'longitud' => -91.5280, 'created_at' => now(), 'updated_at' => now()],
            ['id_zona' => 6, 'id_tipo_zona' => 1, 'nombre' => 'Zona 6 Llanos del Pinal', 'latitud' => 14.8280, 'longitud' => -91.5250, 'created_at' => now(), 'updated_at' => now()],
            ['id_zona' => 7, 'id_tipo_zona' => 1, 'nombre' => 'Zona 7 Cabañas', 'latitud' => 14.8335, 'longitud' => -91.5350, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($zonas as $zona) {
            DB::table('zonas')->updateOrInsert(['id_zona' => $zona['id_zona']], $zona);
        }
    }
}