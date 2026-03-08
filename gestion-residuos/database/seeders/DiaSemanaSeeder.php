<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiaSemana;

class DiaSemanaSeeder extends Seeder
{
    /**
     * inicializa los nombres de los días de la semana municipal
     */
    public function run(): void
    {
        $dias = [
            ['id_dia_semana' => 1, 'nombre' => 'Lunes'],
            ['id_dia_semana' => 2, 'nombre' => 'Martes'],
            ['id_dia_semana' => 3, 'nombre' => 'Miércoles'],
            ['id_dia_semana' => 4, 'nombre' => 'Jueves'],
            ['id_dia_semana' => 5, 'nombre' => 'Viernes'],
            ['id_dia_semana' => 6, 'nombre' => 'Sábado'],
            ['id_dia_semana' => 7, 'nombre' => 'Domingo'],
        ];

        foreach ($dias as $dia) {
            DiaSemana::updateOrCreate(['id_dia_semana' => $dia['id_dia_semana']], $dia);
        }
    }
}
