<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthService
{
    /**
     * Intenta autenticar a un usuario con su correo y contraseña
     * 
     * @param string $correo Correo electrónico del usuario
     * @param string $password Contraseña en texto plano
     * @param bool $remember Si se debe recordar la sesión (opcional)
     * @return bool Retorna verdadero si la autenticación es exitosa
     */
    public function login(string $correo, string $password, bool $remember = false): bool
    {
        // Usa las credenciales para hacer login. Además valida que la cuenta esté activa
        $credentials = [
            'correo' => $correo,
            'password' => $password,
            'activo' => 1,
        ];

        return Auth::attempt($credentials, $remember);
    }

    /**
     * Cierra la sesión activa del usuario
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Registra a un nuevo ciudadano en el sistema
     * @param array $data Datos validados del formulario de registro
     * @return Usuario
     */
    public function registrarCiudadano(array $data): Usuario
    {
        return Usuario::create([
            'id_rol' => 4, // 4 corresponde a "Ciudadano" en RolSeeder
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'] ?? null,
            'password' => Hash::make($data['password']),
            'activo' => 1,
        ]);
    }

    // registra un usuario administrativo permitiendo elegir el rol municipal guatemalteco
    public function crearUsuarioAdministrativo(array $data): Usuario
    {
        return Usuario::create([
            'id_rol' => $data['id_rol'],
            'nombre' => $data['nombre'],
            'correo' => $data['correo'],
            'telefono' => $data['telefono'] ?? null,
            'password' => Hash::make($data['password']),
            'activo' => 1,
        ]);
    }

    // obtiene todos los usuarios con su respectivo rol de la base de datos
    public function listarTodos()
    {
        return Usuario::with('rol')->get();
    }

    // desactiva la cuenta de un usuario para que no pueda entrar mas al sistema muni
    public function desactivar($id_usuario)
    {
        $usuario = Usuario::findOrFail($id_usuario);
        $usuario->update(['activo' => 0]);
        return $usuario;
    }

    // permite crear un nuevo rol dinamicamente desde el panel administrativo
    public function crearRol(array $data)
    {
        return \App\Models\Rol::create([
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'] ?? null
        ]);
    }
}
