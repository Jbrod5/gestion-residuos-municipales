<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    // Ejecuta los seeds de la base de datos
    public function run(): void
    {
        $roles = [
            [
                'id_rol' => 1,
                'nombre' => 'Administrador Municipal',
                'descripcion' => 'Acceso total al sistema y gestion general'
            ],
            [
                'id_rol' => 2,
                'nombre' => 'Coordinador de Rutas',
                'descripcion' => 'Planificacion de rutas y asignacion de camiones'
            ],
            [
                'id_rol' => 3,
                'nombre' => 'Operador de Punto Verde',
                'descripcion' => 'Registro de entregas de reciclaje y niveles'
            ],
            [
                'id_rol' => 4,
                'nombre' => 'Ciudadano',
                'descripcion' => 'Consulta publica y reporte de denuncias'
            ],
            [
                'id_rol' => 5,
                'nombre' => 'Auditor',
                'descripcion' => 'Consulta de reportes y validacion de datos'
            ],
            [
                'id_rol' => 6,
                'nombre' => 'Conductor',
                'descripcion' => 'Operador de camiones recolectores, gestiona rutas asignadas'
            ]
        ];

        foreach ($roles as $rol) {
            Rol::updateOrCreate(['id_rol' => $rol['id_rol']], $rol);
        }
    }
}
