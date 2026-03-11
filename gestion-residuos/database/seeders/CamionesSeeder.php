<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CamionesSeeder extends Seeder
{
    public function run(): void
    {
        $camiones = [
            [
                'id_camion' => 1,
                'placa' => 'P-123ABC',
                'capacidad_toneladas' => 5.5,
                'id_estado_camion' => 1, // Operativo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_camion' => 2,
                'placa' => 'P-456DEF',
                'capacidad_toneladas' => 8.0,
                'id_estado_camion' => 1, // Operativo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_camion' => 3,
                'placa' => 'P-789GHI',
                'capacidad_toneladas' => 10.0,
                'id_estado_camion' => 2, // En Mantenimiento
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_camion' => 4,
                'placa' => 'P-321JKL',
                'capacidad_toneladas' => 6.2,
                'id_estado_camion' => 1, // Operativo
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_camion' => 5,
                'placa' => 'P-654MNO',
                'capacidad_toneladas' => 7.5,
                'id_estado_camion' => 3, // Fuera de Servicio
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($camiones as $camion) {
            DB::table('camiones')->updateOrInsert(
                ['id_camion' => $camion['id_camion']],
                $camion
            );
        }
    }
}