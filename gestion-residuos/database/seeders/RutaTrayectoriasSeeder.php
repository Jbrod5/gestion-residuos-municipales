<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutaTrayectoriasSeeder extends Seeder
{
    public function run(): void
    {
        $trayectorias = [];
        $id = 1;
        
        // Generar trayectorias para cada ruta (10-20 puntos por ruta)
        for ($ruta = 1; $ruta <= 10; $ruta++) {
            $numPuntos = rand(10, 20);
            
            for ($i = 0; $i < $numPuntos; $i++) {
                $rutaData = DB::table('rutas')->where('id_ruta', $ruta)->first();
                
                if ($rutaData) {
                    $factor = $i / ($numPuntos - 1);
                    $lat = $rutaData->latitud_inicio + ($rutaData->latitud_fin - $rutaData->latitud_inicio) * $factor;
                    $lng = $rutaData->longitud_inicio + ($rutaData->longitud_fin - $rutaData->longitud_inicio) * $factor;
                    
                    // Añadir algo de variación para simular calles
                    if ($i > 0 && $i < $numPuntos - 1) {
                        $lat += (rand(-5, 5) / 10000);
                        $lng += (rand(-5, 5) / 10000);
                    }
                    
                    $trayectorias[] = [
                        'id_trayectoria' => $id++,
                        'id_ruta' => $ruta,
                        'latitud' => $lat,
                        'longitud' => $lng,
                        'orden' => $i,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        foreach ($trayectorias as $trayectoria) {
            DB::table('ruta_trayectorias')->updateOrInsert(
                ['id_trayectoria' => $trayectoria['id_trayectoria']],
                $trayectoria
            );
        }
    }
}