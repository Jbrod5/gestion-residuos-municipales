<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PuntoVerdeHorarioSeeder extends Seeder
{
    public function run(): void
    {
        $puntos = DB::table('puntos_verde')->pluck('id_punto_verde')->toArray();
        
        if (empty($puntos)) {
            return;
        }

        $horarios = [];
        $id = 1;

        // Definir horarios base para cada punto
        $configHorarios = [
            1 => [ // Centro Histórico
                'dias' => [1,2,3,4,5,6], // Lunes a Sábado
                'horario' => ['08:00:00', '17:00:00'],
                'horario_sabado' => ['08:00:00', '12:00:00']
            ],
            2 => [ // El Calvario
                'dias' => [1,2,3,4,5,6], // Lunes a Sábado
                'horario' => ['09:00:00', '18:00:00']
            ],
            3 => [ // Minerva
                'dias' => [1,2,3,4,5], // Lunes a Viernes
                'horario' => ['07:00:00', '16:00:00']
            ],
            4 => [ // Las Américas
                'dias' => [1,2,3,4,5,6], // Lunes a Sábado
                'horario' => ['08:00:00', '17:00:00']
            ],
            5 => [ // La Floresta
                'dias' => [2,3,4,5,6,7], // Martes a Domingo
                'horario' => ['09:00:00', '18:00:00']
            ],
            6 => [ // Llanos del Pinal
                'dias' => [1,2,3,4,5,6], // Lunes a Sábado
                'horario' => ['08:00:00', '17:00:00'],
                'horario_sabado' => ['08:00:00', '14:00:00']
            ],
            7 => [ // Cabañas
                'dias' => [3,4,5,6,7], // Miércoles a Domingo
                'horario' => ['09:00:00', '17:00:00']
            ],
        ];

        foreach ($puntos as $puntoId) {
            $config = $configHorarios[$puntoId] ?? [
                'dias' => [1,2,3,4,5],
                'horario' => ['08:00:00', '17:00:00']
            ];

            foreach ($config['dias'] as $dia) {
                // Verificar si es sábado y tiene horario especial
                if ($dia == 6 && isset($config['horario_sabado'])) {
                    $inicio = $config['horario_sabado'][0];
                    $fin = $config['horario_sabado'][1];
                } else {
                    $inicio = $config['horario'][0];
                    $fin = $config['horario'][1];
                }

                $horarios[] = [
                    'id_punto_verde_horario' => $id++,
                    'id_punto_verde' => $puntoId,
                    'id_dia_semana' => $dia,
                    'hora_inicio' => $inicio,
                    'hora_fin' => $fin,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('punto_verde_horario')->insert($horarios);
    }
}