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
        // primero aseguramos un tipo de zona base ya que es requerida por la FK
        $id_tipo = DB::table('tipo_zonas')->insertGetId([
            'nombre' => 'Urbana',
            'descripcion' => 'Sector urbano municipal estándar  ',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


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