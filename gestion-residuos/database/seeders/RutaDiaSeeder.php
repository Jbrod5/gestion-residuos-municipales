<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RutaDiaSeeder extends Seeder
{
    public function run(): void
    {
        $rutas_dias = [
            // Ruta 1: Lunes, Miércoles, Viernes
            ['id_ruta_dia' => 1, 'id_ruta' => 1, 'id_dia_semana' => 1, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            ['id_ruta_dia' => 2, 'id_ruta' => 1, 'id_dia_semana' => 3, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            ['id_ruta_dia' => 3, 'id_ruta' => 1, 'id_dia_semana' => 5, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            
            // Ruta 2: Martes, Jueves, Sábado
            ['id_ruta_dia' => 4, 'id_ruta' => 2, 'id_dia_semana' => 2, 'hora_inicio' => '13:00:00', 'hora_fin' => '19:00:00'],
            ['id_ruta_dia' => 5, 'id_ruta' => 2, 'id_dia_semana' => 4, 'hora_inicio' => '13:00:00', 'hora_fin' => '19:00:00'],
            ['id_ruta_dia' => 6, 'id_ruta' => 2, 'id_dia_semana' => 6, 'hora_inicio' => '13:00:00', 'hora_fin' => '19:00:00'],
            
            // Ruta 3: Lunes, Miércoles, Viernes
            ['id_ruta_dia' => 7, 'id_ruta' => 3, 'id_dia_semana' => 1, 'hora_inicio' => '07:00:00', 'hora_fin' => '13:00:00'],
            ['id_ruta_dia' => 8, 'id_ruta' => 3, 'id_dia_semana' => 3, 'hora_inicio' => '07:00:00', 'hora_fin' => '13:00:00'],
            ['id_ruta_dia' => 9, 'id_ruta' => 3, 'id_dia_semana' => 5, 'hora_inicio' => '07:00:00', 'hora_fin' => '13:00:00'],
            
            // Ruta 4: Martes, Jueves
            ['id_ruta_dia' => 10, 'id_ruta' => 4, 'id_dia_semana' => 2, 'hora_inicio' => '08:00:00', 'hora_fin' => '14:00:00'],
            ['id_ruta_dia' => 11, 'id_ruta' => 4, 'id_dia_semana' => 4, 'hora_inicio' => '08:00:00', 'hora_fin' => '14:00:00'],
            
            // Ruta 5: Lunes a Viernes
            ['id_ruta_dia' => 12, 'id_ruta' => 5, 'id_dia_semana' => 1, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            ['id_ruta_dia' => 13, 'id_ruta' => 5, 'id_dia_semana' => 2, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            ['id_ruta_dia' => 14, 'id_ruta' => 5, 'id_dia_semana' => 3, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            ['id_ruta_dia' => 15, 'id_ruta' => 5, 'id_dia_semana' => 4, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            ['id_ruta_dia' => 16, 'id_ruta' => 5, 'id_dia_semana' => 5, 'hora_inicio' => '06:00:00', 'hora_fin' => '12:00:00'],
            
            // Ruta 6: Miércoles, Sábado
            ['id_ruta_dia' => 17, 'id_ruta' => 6, 'id_dia_semana' => 3, 'hora_inicio' => '07:00:00', 'hora_fin' => '13:00:00'],
            ['id_ruta_dia' => 18, 'id_ruta' => 6, 'id_dia_semana' => 6, 'hora_inicio' => '07:00:00', 'hora_fin' => '13:00:00'],
            
            // Ruta 7: Martes, Viernes
            ['id_ruta_dia' => 19, 'id_ruta' => 7, 'id_dia_semana' => 2, 'hora_inicio' => '08:00:00', 'hora_fin' => '14:00:00'],
            ['id_ruta_dia' => 20, 'id_ruta' => 7, 'id_dia_semana' => 5, 'hora_inicio' => '08:00:00', 'hora_fin' => '14:00:00'],
            
            // Ruta 8: Jueves, Domingo
            ['id_ruta_dia' => 21, 'id_ruta' => 8, 'id_dia_semana' => 4, 'hora_inicio' => '09:00:00', 'hora_fin' => '15:00:00'],
            ['id_ruta_dia' => 22, 'id_ruta' => 8, 'id_dia_semana' => 7, 'hora_inicio' => '09:00:00', 'hora_fin' => '15:00:00'],
            
            // Ruta 9: Sábado (reciclaje)
            ['id_ruta_dia' => 23, 'id_ruta' => 9, 'id_dia_semana' => 6, 'hora_inicio' => '08:00:00', 'hora_fin' => '14:00:00'],
            
            // Ruta 10: Domingo (reciclaje)
            ['id_ruta_dia' => 24, 'id_ruta' => 10, 'id_dia_semana' => 7, 'hora_inicio' => '08:00:00', 'hora_fin' => '14:00:00'],
        ];

        foreach ($rutas_dias as $rd) {
            DB::table('ruta_dia')->updateOrInsert(
                ['id_ruta_dia' => $rd['id_ruta_dia']],
                $rd
            );
        }
    }
}