<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoResiduoSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['id_tipo_residuo' => 1, 'nombre' => 'Orgánico', 'descripcion' => 'Residuos biodegradables de origen vegetal o animal'],
            ['id_tipo_residuo' => 2, 'nombre' => 'Inorgánico', 'descripcion' => 'Residuos no biodegradables como plásticos no reciclables'],
            ['id_tipo_residuo' => 3, 'nombre' => 'Mixto', 'descripcion' => 'Mezcla de residuos orgánicos e inorgánicos'],
            ['id_tipo_residuo' => 4, 'nombre' => 'Reciclable', 'descripcion' => 'Residuos aprovechables para reciclaje'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipo_residuos')->updateOrInsert(['id_tipo_residuo' => $tipo['id_tipo_residuo']], $tipo);
        }
    }
}

