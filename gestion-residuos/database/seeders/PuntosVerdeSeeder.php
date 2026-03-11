<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntosVerdeSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener IDs de operadores de punto verde (rol 3)
        $operadores = DB::table('usuarios')
            ->where('id_rol', 3)
            ->pluck('id_usuario')
            ->toArray();

        // Si no hay suficientes operadores, usar IDs por defecto
        if (count($operadores) < 4) {
            $operadores = [3, 3, 3, 3]; // Mismo operador para varios puntos
        }

        $puntos = [
            [
                'id_punto_verde' => 1,
                'nombre' => 'Punto Verde Centro Histórico',
                'direccion' => '6a Avenida 12-34, Zona 1',
                'horario' => 'Lun-Vie 8:00-17:00, Sáb 8:00-12:00',
                'capacidad_total_m3' => 50,
                'latitud' => 14.8400,
                'longitud' => -91.5200,
                'id_encargado' => 3, // operador fijo :3
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_punto_verde' => 2,
                'nombre' => 'Punto Verde El Calvario',
                'direccion' => '3a Calle 5-40, Zona 2',
                'horario' => 'Lun-Sáb 9:00-18:00',
                'capacidad_total_m3' => 75,
                'latitud' => 14.8380,
                'longitud' => -91.5170,
                'id_encargado' => $operadores[1] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_punto_verde' => 3,
                'nombre' => 'Punto Verde Minerva',
                'direccion' => '7a Avenida 1-20, Zona 3',
                'horario' => 'Lun-Vie 7:00-16:00',
                'capacidad_total_m3' => 60,
                'latitud' => 14.8455,
                'longitud' => -91.5195,
                'id_encargado' => $operadores[2] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_punto_verde' => 4,
                'nombre' => 'Punto Verde Las Américas',
                'direccion' => 'Calzada Roosevelt 45-67, Zona 4',
                'horario' => 'Lun-Sáb 8:00-17:00',
                'capacidad_total_m3' => 80,
                'latitud' => 14.8465,
                'longitud' => -91.5310,
                'id_encargado' => $operadores[3] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_punto_verde' => 5,
                'nombre' => 'Punto Verde La Floresta',
                'direccion' => 'Boulevard El Frutal 23-45, Zona 5',
                'horario' => 'Mar-Dom 9:00-18:00',
                'capacidad_total_m3' => 55,
                'latitud' => 14.8365,
                'longitud' => -91.5280,
                'id_encargado' => $operadores[0] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_punto_verde' => 6,
                'nombre' => 'Punto Verde Llanos del Pinal',
                'direccion' => '4a Calle 10-20, Zona 6',
                'horario' => 'Lun-Vie 8:00-17:00, Sáb 8:00-14:00',
                'capacidad_total_m3' => 45,
                'latitud' => 14.8280,
                'longitud' => -91.5250,
                'id_encargado' => $operadores[1] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_punto_verde' => 7,
                'nombre' => 'Punto Verde Cabañas',
                'direccion' => 'Carretera a El Salvador Km 8.5, Zona 7',
                'horario' => 'Mié-Dom 9:00-17:00',
                'capacidad_total_m3' => 70,
                'latitud' => 14.8335,
                'longitud' => -91.5350,
                'id_encargado' => $operadores[2] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($puntos as $punto) {
            // Insertar o actualizar el punto verde
            DB::table('puntos_verde')->updateOrInsert(
                ['id_punto_verde' => $punto['id_punto_verde']],
                $punto
            );
            
            // Actualizar el usuario encargado con el id_punto_verde
            DB::table('usuarios')
                ->where('id_usuario', $punto['id_encargado'])
                ->update(['id_punto_verde' => $punto['id_punto_verde']]);
        }
    }
}