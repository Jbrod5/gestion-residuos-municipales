<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContenedoresSeeder extends Seeder
{
    public function run(): void
    {
        $contenedores = [
            // Punto Verde 1
            [
                'id_contenedor' => 1,
                'id_punto_verde' => 1,
                'id_material' => 1, // Papel y Cartón
                'capacidad_maxima_m3' => 10,
                'nivel_actual_m3' => 3.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 2,
                'id_punto_verde' => 1,
                'id_material' => 2, // Plástico PET
                'capacidad_maxima_m3' => 8,
                'nivel_actual_m3' => 6.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 3,
                'id_punto_verde' => 1,
                'id_material' => 3, // Vidrio
                'capacidad_maxima_m3' => 12,
                'nivel_actual_m3' => 4.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Punto Verde 2
            [
                'id_contenedor' => 4,
                'id_punto_verde' => 2,
                'id_material' => 1, // Papel y Cartón
                'capacidad_maxima_m3' => 15,
                'nivel_actual_m3' => 8.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 5,
                'id_punto_verde' => 2,
                'id_material' => 2, // Plástico PET
                'capacidad_maxima_m3' => 10,
                'nivel_actual_m3' => 9.5, // Casi lleno (95%)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 6,
                'id_punto_verde' => 2,
                'id_material' => 4, // Metal
                'capacidad_maxima_m3' => 8,
                'nivel_actual_m3' => 2.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Punto Verde 3
            [
                'id_contenedor' => 7,
                'id_punto_verde' => 3,
                'id_material' => 1, // Papel y Cartón
                'capacidad_maxima_m3' => 12,
                'nivel_actual_m3' => 10.8, // 90% - Alerta urgente
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 8,
                'id_punto_verde' => 3,
                'id_material' => 3, // Vidrio
                'capacidad_maxima_m3' => 10,
                'nivel_actual_m3' => 7.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 9,
                'id_punto_verde' => 3,
                'id_material' => 5, // Electrónicos
                'capacidad_maxima_m3' => 6,
                'nivel_actual_m3' => 1.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Punto Verde 4
            [
                'id_contenedor' => 10,
                'id_punto_verde' => 4,
                'id_material' => 2, // Plástico PET
                'capacidad_maxima_m3' => 15,
                'nivel_actual_m3' => 14.5, // 97% - Muy cerca del límite
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 11,
                'id_punto_verde' => 4,
                'id_material' => 4, // Metal
                'capacidad_maxima_m3' => 10,
                'nivel_actual_m3' => 3.8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Punto Verde 5
            [
                'id_contenedor' => 12,
                'id_punto_verde' => 5,
                'id_material' => 1, // Papel y Cartón
                'capacidad_maxima_m3' => 12,
                'nivel_actual_m3' => 6.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 13,
                'id_punto_verde' => 5,
                'id_material' => 3, // Vidrio
                'capacidad_maxima_m3' => 8,
                'nivel_actual_m3' => 5.2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Punto Verde 6
            [
                'id_contenedor' => 14,
                'id_punto_verde' => 6,
                'id_material' => 2, // Plástico PET
                'capacidad_maxima_m3' => 10,
                'nivel_actual_m3' => 2.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 15,
                'id_punto_verde' => 6,
                'id_material' => 5, // Electrónicos
                'capacidad_maxima_m3' => 5,
                'nivel_actual_m3' => 4.2, // 84% - Alerta temprana
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            // Punto Verde 7
            [
                'id_contenedor' => 16,
                'id_punto_verde' => 7,
                'id_material' => 1, // Papel y Cartón
                'capacidad_maxima_m3' => 15,
                'nivel_actual_m3' => 15.0, // 100% - COMPLETAMENTE LLENO
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_contenedor' => 17,
                'id_punto_verde' => 7,
                'id_material' => 4, // Metal
                'capacidad_maxima_m3' => 8,
                'nivel_actual_m3' => 3.0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($contenedores as $contenedor) {
            DB::table('contenedores')->updateOrInsert(
                ['id_contenedor' => $contenedor['id_contenedor']],
                $contenedor
            );
        }
    }
}