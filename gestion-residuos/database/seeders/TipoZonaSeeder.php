<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoZonaSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['id_tipo_zona' => 1, 'nombre' => 'Residencial', 'descripcion' => 'Barrios y colonias de vivienda familiar'],
            ['id_tipo_zona' => 2, 'nombre' => 'Comercial', 'descripcion' => 'Áreas con alta concentración de comercios y servicios'],
            ['id_tipo_zona' => 3, 'nombre' => 'Industrial', 'descripcion' => 'Zonas con actividad industrial y bodegas'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipo_zonas')->updateOrInsert(['id_tipo_zona' => $tipo['id_tipo_zona']], $tipo);
        }
    }
}

