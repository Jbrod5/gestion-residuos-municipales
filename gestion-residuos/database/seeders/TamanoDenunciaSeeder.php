<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TamanoDenunciaSeeder extends Seeder
{
    public function run(): void
    {
        $tamanos = [
            ['id_tamano_denuncia' => 1, 'nombre' => 'Pequeño', 'descripcion' => 'Basurero de proporciones menores'],
            ['id_tamano_denuncia' => 2, 'nombre' => 'Mediano', 'descripcion' => 'Basurero con cantidad considerable de residuos'],
            ['id_tamano_denuncia' => 3, 'nombre' => 'Grande', 'descripcion' => 'Basurero clandestino extenso con gran impacto'],
        ];

        foreach ($tamanos as $tamano) {
            DB::table('tamanos_denuncia')->updateOrInsert(['id_tamano_denuncia' => $tamano['id_tamano_denuncia']], $tamano);
        }
    }
}
