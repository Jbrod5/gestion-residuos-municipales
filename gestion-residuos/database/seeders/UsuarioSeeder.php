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
        // Ejecutamos primero el seeder de roles para evitar llaves foraneas faltantes
        $this->call(RolSeeder::class);

        // Crear el usuario con correo exacto del sistema
        Usuario::updateOrCreate(
            ['correo' => 'admin@sistema.com'],
            [
                'id_rol' => 1, // 1 es Administrador Municipal según RolSeeder
                'nombre' => 'Super Admin',
                'password' => Hash::make('password123'),
                'telefono' => '1234567890',
                'activo' => 1,
            ]
        );
    }
}
