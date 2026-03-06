<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Rol;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Ejecuta los seeds de la base de datos.
     */
    public function run(): void
    {
        // Crear el rol con ID 1 "Administrador" si no existe
        $rolAdmin = Rol::firstOrCreate(
            ['id_rol' => 1],
            [
                'nombre' => 'Administrador',
                'descripcion' => 'Rol de prueba con privilegios máximos.'
            ]
        );

        // Crear el usuario con correo exacto del sistema
        Usuario::firstOrCreate(
            ['correo' => 'admin@sistema.com'],
            [
                'id_rol' => $rolAdmin->id_rol,
                'nombre' => 'Super Admin',
                'password' => Hash::make('password123'),
                'telefono' => '1234567890',
                'activo' => 1,
            ]
        );
    }
}
