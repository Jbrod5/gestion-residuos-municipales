<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

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
}
