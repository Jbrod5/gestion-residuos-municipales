<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $authService;

    // Inyectamos el servicio de autenticación
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Muestra el formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Maneja la petición POST para registrar al ciudadano
   public function register(Request $request)
{
    // Validamos la entrada
    $validatedData = $request->validate([
        'nombre' => ['required', 'string', 'max:255'],
        'correo' => ['required', 'string', 'email', 'max:255', 'unique:usuarios,correo'],
        'telefono' => ['nullable', 'string', 'max:15'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ], [
        'nombre.required' => 'El nombre completo es obligatorio.',
        'correo.required' => 'El correo electrónico es obligatorio.',
        'correo.email' => 'Por favor, ingresa un correo electrónico válido.',
        'correo.unique' => 'Este correo ya se encuentra registrado en el sistema.',
        'password.required' => 'La contraseña es obligatoria.',
        'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        'password.confirmed' => 'La confirmación de la contraseña no coincide.',
    ]);

    // Delegamos la creación al servicio
    $usuario = $this->authService->registrarCiudadano($validatedData);

    // Iniciamos sesión automáticamente :3
    Auth::login($usuario);

    // Redirigimos al dashboard
    return redirect()->route('dashboard');
}
}
