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
        DB::table('tipo_zonas')->insert([
            ['nombre' => 'Urbana', 'descripcion' => 'Sector urbano municipal estándar', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Industrial', 'descripcion' => 'Sector de alta generación industrial', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Comercial', 'descripcion' => 'Sector de alta rotación comercial', 'created_at' => now(), 'updated_at' => now()],
        ]);

        $id_urbana = DB::table('tipo_zonas')->where('nombre', 'Urbana')->value('id_tipo_zona');

        $zonas = [
            ['id_tipo_zona' => $id_urbana, 'nombre' => 'Zona 1', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_urbana, 'nombre' => 'Zona 2', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_urbana, 'nombre' => 'Zona 3', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_urbana, 'nombre' => 'Zona 4', 'created_at' => now(), 'updated_at' => now()],
            ['id_tipo_zona' => $id_urbana, 'nombre' => 'Zona 5', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('zonas')->insert($zonas);
    }
}