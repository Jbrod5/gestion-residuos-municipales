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
            ['nombre' => 'Plástico PET', 'descripcion' => 'Botellas de refresco y envases transparentes'],
            ['nombre' => 'Papel y Cartón', 'descripcion' => 'Hojas bond periódico y cajas de embalaje'],
            ['nombre' => 'Vidrio', 'descripcion' => 'Botellas y frascos de vidrio de cualquier color'],
            ['nombre' => 'Aluminio', 'descripcion' => 'Latas de bebidas y conservas'],
            ['nombre' => 'Tetra Pak', 'descripcion' => 'Envases de leche y jugos multicapa'],
        ];

        foreach ($materiales as $material) {
            Material::updateOrCreate(['nombre' => $material['nombre']], $material);
        }
    }
}
