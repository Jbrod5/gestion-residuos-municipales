<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutasSeeder extends Seeder
{
    public function run(): void
    {
        $rutas = [
            [
                'id_ruta' => 1,
                'id_zona' => 1, // Zona 1
                'id_tipo_residuo' => 3, // Mixto
                'nombre' => 'Ruta Centro Histórico - Mañana',
                'poblacion_estimada' => 15000,
                'distancia_km' => 12.5,
                'latitud_inicio' => 14.8400,
                'longitud_inicio' => -91.5200,
                'latitud_fin' => 14.8450,
                'longitud_fin' => -91.5250,
                'basura_total_estimada' => 4.2,
                'id_punto_verde' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 2,
                'id_zona' => 1, // Zona 1
                'id_tipo_residuo' => 3, // Mixto
                'nombre' => 'Ruta Centro Histórico - Tarde',
                'poblacion_estimada' => 15000,
                'distancia_km' => 11.8,
                'latitud_inicio' => 14.8420,
                'longitud_inicio' => -91.5220,
                'latitud_fin' => 14.8380,
                'longitud_fin' => -91.5180,
                'basura_total_estimada' => 3.8,
                'id_punto_verde' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 3,
                'id_zona' => 2, // Zona 2
                'id_tipo_residuo' => 1, // Orgánico
                'nombre' => 'Ruta El Calvario',
                'poblacion_estimada' => 12000,
                'distancia_km' => 8.3,
                'latitud_inicio' => 14.8380,
                'longitud_inicio' => -91.5170,
                'latitud_fin' => 14.8350,
                'longitud_fin' => -91.5200,
                'basura_total_estimada' => 3.5,
                'id_punto_verde' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 4,
                'id_zona' => 3, // Zona 3
                'id_tipo_residuo' => 2, // Inorgánico
                'nombre' => 'Ruta Minerva',
                'poblacion_estimada' => 8000,
                'distancia_km' => 6.7,
                'latitud_inicio' => 14.8455,
                'longitud_inicio' => -91.5195,
                'latitud_fin' => 14.8480,
                'longitud_fin' => -91.5220,
                'basura_total_estimada' => 2.9,
                'id_punto_verde' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 5,
                'id_zona' => 4, // Zona 4
                'id_tipo_residuo' => 3, // Mixto
                'nombre' => 'Ruta Las Américas',
                'poblacion_estimada' => 18000,
                'distancia_km' => 10.2,
                'latitud_inicio' => 14.8465,
                'longitud_inicio' => -91.5310,
                'latitud_fin' => 14.8500,
                'longitud_fin' => -91.5350,
                'basura_total_estimada' => 5.1,
                'id_punto_verde' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 6,
                'id_zona' => 5, // Zona 5
                'id_tipo_residuo' => 1, // Orgánico
                'nombre' => 'Ruta La Floresta',
                'poblacion_estimada' => 10000,
                'distancia_km' => 7.5,
                'latitud_inicio' => 14.8365,
                'longitud_inicio' => -91.5280,
                'latitud_fin' => 14.8320,
                'longitud_fin' => -91.5300,
                'basura_total_estimada' => 3.2,
                'id_punto_verde' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 7,
                'id_zona' => 6, // Zona 6
                'id_tipo_residuo' => 2, // Inorgánico
                'nombre' => 'Ruta Llanos del Pinal',
                'poblacion_estimada' => 7000,
                'distancia_km' => 9.0,
                'latitud_inicio' => 14.8280,
                'longitud_inicio' => -91.5250,
                'latitud_fin' => 14.8250,
                'longitud_fin' => -91.5280,
                'basura_total_estimada' => 2.5,
                'id_punto_verde' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 8,
                'id_zona' => 7, // Zona 7
                'id_tipo_residuo' => 3, // Mixto
                'nombre' => 'Ruta Cabañas',
                'poblacion_estimada' => 9000,
                'distancia_km' => 8.8,
                'latitud_inicio' => 14.8335,
                'longitud_inicio' => -91.5350,
                'latitud_fin' => 14.8300,
                'longitud_fin' => -91.5380,
                'basura_total_estimada' => 3.0,
                'id_punto_verde' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 9,
                'id_zona' => 2, // Zona 2
                'id_tipo_residuo' => 4, // Reciclable
                'nombre' => 'Ruta Reciclaje El Calvario',
                'poblacion_estimada' => 5000,
                'distancia_km' => 5.2,
                'latitud_inicio' => 14.8370,
                'longitud_inicio' => -91.5180,
                'latitud_fin' => 14.8400,
                'longitud_fin' => -91.5200,
                'basura_total_estimada' => 1.8,
                'id_punto_verde' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_ruta' => 10,
                'id_zona' => 4, // Zona 4
                'id_tipo_residuo' => 4, // Reciclable
                'nombre' => 'Ruta Reciclaje Las Américas',
                'poblacion_estimada' => 6000,
                'distancia_km' => 6.5,
                'latitud_inicio' => 14.8470,
                'longitud_inicio' => -91.5320,
                'latitud_fin' => 14.8450,
                'longitud_fin' => -91.5300,
                'basura_total_estimada' => 2.2,
                'id_punto_verde' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($rutas as $ruta) {
            DB::table('rutas')->updateOrInsert(
                ['id_ruta' => $ruta['id_ruta']],
                $ruta
            );
        }
    }
}