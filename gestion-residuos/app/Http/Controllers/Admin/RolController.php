<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // muestra el listado de roles municipales disponibles en el sistema guatemalteco 2026
    public function index()
    {
        $roles = Rol::all();
        return view('admin.roles.index', compact('roles'));
    }

    // muestra el formulario para crear un nuevo rol administrativo municipal
    public function create()
    {
        return view('admin.roles.create');
    }

    // guarda el nuevo rol en la base de datos de forma dinamica y profesional
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:roles,nombre',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $this->authService->crearRol($request->all());

        return redirect()->route('admin.roles.index')
            ->with('success', 'nuevo rol municipal registrado con exito rotundo y absoluto');
    }
}
