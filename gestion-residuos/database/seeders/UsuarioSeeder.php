<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Ejecuta los seeds de la base de datos.
     */
    public function run(): void
    {
        // Definimos los usuarios para cada rol del sistema
        $usuarios = [
            [
                'id_rol' => 1, // Administrador Municipal
                'nombre' => 'Admin Municipal Xela',
                'correo' => 'admin@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610001',
                'activo' => 1,
            ],
            [
                'id_rol' => 2, // Coordinador de Rutas
                'nombre' => 'Ing. Carlos Rodriguez',
                'correo' => 'coordinador@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610002',
                'activo' => 1,
            ],
            [
                'id_rol' => 3, // Operador de Punto Verde
                'nombre' => 'Juan Perez Operador',
                'correo' => 'operador@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610003',
                'activo' => 1,
            ],
            [
                'id_rol' => 4, // Ciudadano
                'nombre' => 'Jorge Bravo',
                'correo' => 'ciudadano@correo.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610004',
                'activo' => 1,
            ],
            [
                'id_rol' => 5, // Auditor
                'nombre' => 'Licda. Maria Auditora',
                'correo' => 'auditor@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610005',
                'activo' => 1,
            ],
        ];

        foreach ($usuarios as $u) {
            Usuario::updateOrCreate(
                ['correo' => $u['correo']],
                $u
            );
        }
    }
}