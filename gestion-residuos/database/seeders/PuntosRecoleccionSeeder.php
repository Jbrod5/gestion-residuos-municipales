<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntosRecoleccionSeeder extends Seeder
{
    public function run(): void
    {
        $puntos = [];
        $id = 1;
        
        // Generar puntos para cada ruta (15-30 puntos por ruta)
        for ($ruta = 1; $ruta <= 10; $ruta++) {
            $numPuntos = rand(15, 30);
            
            for ($i = 1; $i <= $numPuntos; $i++) {
                // Obtener datos base de la ruta
                $rutaData = DB::table('rutas')->where('id_ruta', $ruta)->first();
                
                if ($rutaData) {
                    // Variar ligeramente las coordenadas para simular puntos a lo largo de la ruta
                    $factor = $i / $numPuntos;
                    $lat = $rutaData->latitud_inicio + ($rutaData->latitud_fin - $rutaData->latitud_inicio) * $factor + (rand(-10, 10) / 10000);
                    $lng = $rutaData->longitud_inicio + ($rutaData->longitud_fin - $rutaData->longitud_inicio) * $factor + (rand(-10, 10) / 10000);
                    
                    $puntos[] = [
                        'id_punto_recoleccion' => $id++,
                        'id_ruta' => $ruta,
                        'posicion_orden' => $i,
                        'latitud' => $lat,
                        'longitud' => $lng,
                        'volumen_estimado_kg' => rand(50, 500),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach ($puntos as $punto) {
            DB::table('puntos_recoleccion')->updateOrInsert(
                ['id_punto_recoleccion' => $punto['id_punto_recoleccion']],
                $punto
            );
        }
    }
}