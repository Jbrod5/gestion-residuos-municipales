<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected $authService;

    // Inyectamos el servicio de autenticación N-Capas :3
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // Muestra la vista de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Gestiona la solicitud de login (POST)
    public function login(Request $request)
    {
        // Validación básica
        $request->validate([
            'correo' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->filled('remember');

        // Consumiendo el servicio de autenticación
        if ($this->authService->login($request->correo, $request->password, $remember)) {
            $request->session()->regenerate();

            $usuario = auth()->user();

            // redireccionamiento dinámico según el rol municipal 
            return match ($usuario->id_rol) {
                    1 => redirect()->route('admin.dashboard'),
                    2 => redirect()->route('coordinator.dashboard'),
                    3 => redirect()->route('operador.dashboard'),
                    4 => redirect()->route('ciudadano.hub'),
                    5 => redirect()->route('auditor.dashboard'),
                    default => redirect('/'),
                };
        }

        // Si falla el login regresamos con un error de credenciales
        return back()->withErrors([
            'correo' => 'Las credenciales proporcionadas no son correctas o la cuenta está inactiva.',
        ])->onlyInput('correo');
    }

    // Gestiona la solicitud de logout (POST)
    public function logout(Request $request)
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}