<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    /**
     * inicializa el catálogo de materiales para los puntos verdes municipal
     */
    public function run(): void
    {
        $materiales = [
            ['id_material' => 1, 'nombre' => 'Papel y Cartón', 'densidad_kg_m3' => 100, 'descripcion' => 'Hojas bond periódico y cajas de embalaje'],
            ['id_material' => 2, 'nombre' => 'Plástico PET', 'densidad_kg_m3' => 40, 'descripcion' => 'Botellas de refresco y envases transparentes'],
            ['id_material' => 3, 'nombre' => 'Vidrio', 'densidad_kg_m3' => 350, 'descripcion' => 'Botellas y frascos de vidrio de cualquier color'],
            ['id_material' => 4, 'nombre' => 'Metal', 'densidad_kg_m3' => 60, 'descripcion' => 'Latas de bebidas y conservas de aluminio o hierro'],
            ['id_material' => 5, 'nombre' => 'Electrónicos', 'densidad_kg_m3' => 120, 'descripcion' => 'Residuos electrónicos y pequeños aparatos'],
        ];

        foreach ($materiales as $material) {
            Material::updateOrCreate(['id_material' => $material['id_material']], $material);
        }
    }
}
