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
        
        $usuarios = [
            // BASICOS
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
                'nombre' => 'Daniel Orozco',
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
            [
                'id_rol' => 6, // Conductor
                'nombre' => 'Juan Francisco Conductor',
                'correo' => 'conductor@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610005',
                'activo' => 1,
            ],



            // ========== ADMINISTRADORES MUNICIPALES (Rol 1) ==========
            [
                'id_rol' => 1,
                'nombre' => 'Carlos Mendoza',
                'correo' => 'carlos.mendoza@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610001',
                'activo' => 1,
            ],
            [
                'id_rol' => 1,
                'nombre' => 'Ana García',
                'correo' => 'ana.garcia@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610002',
                'activo' => 1,
            ],
            [
                'id_rol' => 1,
                'nombre' => 'Roberto Paz',
                'correo' => 'roberto.paz@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610003',
                'activo' => 1,
            ],

            // ========== COORDINADORES DE RUTAS (Rol 2) ==========
            [
                'id_rol' => 2,
                'nombre' => 'Carlos Rodríguez',
                'correo' => 'carlos.rodriguez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610004',
                'activo' => 1,
            ],
            [
                'id_rol' => 2,
                'nombre' => 'María López',
                'correo' => 'maria.lopez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610005',
                'activo' => 1,
            ],
            [
                'id_rol' => 2,
                'nombre' => 'José Ramírez',
                'correo' => 'jose.ramirez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610006',
                'activo' => 1,
            ],
            [
                'id_rol' => 2,
                'nombre' => 'Patricia Méndez',
                'correo' => 'patricia.mendez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610007',
                'activo' => 1,
            ],

            // ========== OPERADORES DE PUNTO VERDE (Rol 3) ==========
            [
                'id_rol' => 3,
                'nombre' => 'Juan Pérez',
                'correo' => 'juan.perez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610008',
                'activo' => 1,
            ],
            [
                'id_rol' => 3,
                'nombre' => 'Luisa Fernández',
                'correo' => 'luisa.fernandez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610009',
                'activo' => 1,
            ],
            [
                'id_rol' => 3,
                'nombre' => 'Pedro Sánchez',
                'correo' => 'pedro.sanchez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610010',
                'activo' => 1,
            ],
            [
                'id_rol' => 3,
                'nombre' => 'Diana Morales',
                'correo' => 'diana.morales@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610011',
                'activo' => 1,
            ],
            [
                'id_rol' => 3,
                'nombre' => 'Jorge Castillo',
                'correo' => 'jorge.castillo@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610012',
                'activo' => 1,
            ],

            // ========== CIUDADANOS (Rol 4) ==========
            [
                'id_rol' => 4,
                'nombre' => 'Daniel Orozco',
                'correo' => 'daniel.orozco@correo.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610013',
                'activo' => 1,
            ],
            [
                'id_rol' => 4,
                'nombre' => 'Carmen Soto',
                'correo' => 'carmen.soto@correo.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610014',
                'activo' => 1,
            ],
            [
                'id_rol' => 4,
                'nombre' => 'Miguel Díaz',
                'correo' => 'miguel.diaz@correo.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610015',
                'activo' => 1,
            ],
            [
                'id_rol' => 4,
                'nombre' => 'Laura Méndez',
                'correo' => 'laura.mendez@correo.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610016',
                'activo' => 1,
            ],
            [
                'id_rol' => 4,
                'nombre' => 'Fernando Reyes',
                'correo' => 'fernando.reyes@correo.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610017',
                'activo' => 1,
            ],

            // ========== AUDITORES (Rol 5) ==========
            [
                'id_rol' => 5,
                'nombre' => 'Sofía Herrera',
                'correo' => 'sofia.herrera@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610018',
                'activo' => 1,
            ],
            [
                'id_rol' => 5,
                'nombre' => 'Manuel Ortíz',
                'correo' => 'manuel.ortiz@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610019',
                'activo' => 1,
            ],
            [
                'id_rol' => 5,
                'nombre' => 'Elena Vargas',
                'correo' => 'elena.vargas@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610020',
                'activo' => 1,
            ],

            // ========== CONDUCTORES (Rol 6) ==========
            [
                'id_rol' => 6,
                'nombre' => 'Juan Francisco Pérez',
                'correo' => 'juan.perez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610021',
                'activo' => 1,
            ],
            [
                'id_rol' => 6,
                'nombre' => 'Luis González',
                'correo' => 'luis.gonzalez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610022',
                'activo' => 1,
            ],
            [
                'id_rol' => 6,
                'nombre' => 'Héctor Ramírez',
                'correo' => 'hector.ramirez@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610023',
                'activo' => 1,
            ],
            [
                'id_rol' => 6,
                'nombre' => 'Miguel Ángel Castro',
                'correo' => 'miguel.castro@muni.com',
                'password' => Hash::make('pass123'),
                'telefono' => '77610024',
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