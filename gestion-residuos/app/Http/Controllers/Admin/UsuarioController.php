<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Models\Rol;
use App\Models\PuntoVerde;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // muestra el listado de todos los usuarios municipales y ciudadanos
    public function index()
    {
        $usuarios = $this->authService->listarTodos();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // muestra el formulario para crear un nuevo usuario con roles dinamicos de la DB
    public function create()
    {
        $roles = Rol::all();
        $puntosVerdes = PuntoVerde::orderBy('nombre')->get();
        return view('admin.usuarios.create', compact('roles', 'puntosVerdes'));
    }

    // procesa la creacion del nuevo usuario administrativo o ciudadano
    public function store(Request $request)
    {
        $request->validate([
            'id_rol' => 'required|exists:roles,id_rol',
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email|unique:usuarios,correo',
            'telefono' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'id_punto_verde' => 'nullable|exists:puntos_verde,id_punto_verde',
        ]);

        $this->authService->crearUsuarioAdministrativo($request->all());

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'usuario municipal creado correctamente');
    }

    // desactiva un usuario para bloquear su acceso al sistema de residuos
    public function destroy($id)
    {
        $this->authService->desactivar($id);
        return redirect()->back()->with('success', 'usuario desactivado con exito');
    }
}