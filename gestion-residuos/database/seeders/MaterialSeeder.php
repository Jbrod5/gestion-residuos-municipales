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
            ['nombre' => 'Plástico PET', 'densidad_kg_m3' => 40, 'descripcion' => 'Botellas de refresco y envases transparentes'],
            ['nombre' => 'Papel y Cartón', 'densidad_kg_m3' => 100, 'descripcion' => 'Hojas bond periódico y cajas de embalaje'],
            ['nombre' => 'Vidrio', 'densidad_kg_m3' => 350, 'descripcion' => 'Botellas y frascos de vidrio de cualquier color'],
            ['nombre' => 'Aluminio', 'densidad_kg_m3' => 60, 'descripcion' => 'Latas de bebidas y conservas'],
            ['nombre' => 'Tetra Pak', 'densidad_kg_m3' => 80, 'descripcion' => 'Envases de leche y jugos multicapa'],
        ];

        foreach ($materiales as $material) {
            Material::updateOrCreate(['nombre' => $material['nombre']], $material);
        }
    }
}
