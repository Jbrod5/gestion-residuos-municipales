<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonaSeeder extends Seeder
{
    /**
     * Seed the application's database with simple zones guatemaltecas 2026.
     */
    public function run(): void
    {
        // primero aseguramos un tipo de zona base ya que es requerida por la FK
        $id_tipo = DB::table('tipo_zonas')->insertGetId([
            'nombre' => 'Urbana',
            'descripcion' => 'Sector urbano municipal estándar  ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // insertamos las 5 zonas solicitadas sin coordenadas basura amén
        $zonas = [
            ['id_tipo_zona' => $id_tipo, 'nombre' => 'Zona 1', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_tipo, 'nombre' => 'Zona 2', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_tipo, 'nombre' => 'Zona 3', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_tipo, 'nombre' => 'Zona 4', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_tipo, 'nombre' => 'Zona 5', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('zonas')->insert($zonas);
    }
}