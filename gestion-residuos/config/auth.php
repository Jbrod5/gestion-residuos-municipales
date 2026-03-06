<?php

return [

    // Opciones por defecto para autenticación y reseteo de contraseñas
    'defaults' => [
        'guard' => env('AUTH_GUARD', 'web'),
        'passwords' => env('AUTH_PASSWORD_BROKER', 'users'),
    ],

    // Guardias de autenticación
    // Define como se autentican los usuarios
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    // Proveedores de usuarios
    // Indica que modelo se usara para buscar usuarios
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\Usuario::class),
        ],
    ],

    // Configuracion para el reseteo de contraseñas (tabla, expiración y limite de tiempo)
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // Tiempo de espera para confirmar la contraseña (en segundos)
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
