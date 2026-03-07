<?php

namespace App\Http\Controllers\Ciudadano;

use App\Http\Controllers\Controller;
use App\Services\DenunciaService;
use Illuminate\Http\Request;

class DenunciaController extends Controller
{
    protected $denunciaService;

    public function __construct(DenunciaService $denunciaService)
    {
        $this->denunciaService = $denunciaService;
    }

    // muestra el listado de denuncias del ciudadano
    public function index()
    {
        $denuncias = $this->denunciaService->obtenerDenunciasCiudadano();
        return view('ciudadano.denuncias.index', compact('denuncias'));
    }

    // muestra el formulario para crear una nueva denuncia
    public function create()
    {
        $tamanos = \App\Models\TamanoDenuncia::all();
        return view('ciudadano.denuncias.create', compact('tamanos'));
    }

    // guarda la nueva denuncia usando el service corregido
    public function store(Request $request)
    {
        $request->validate([
            'id_tamano_denuncia' => 'required|exists:tamanos_denuncia,id_tamano_denuncia',
            'descripcion' => 'required|string|max:1000',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $this->denunciaService->crearDenuncia($request->all(), $request->file('foto'));

        return redirect()->route('ciudadano.denuncias.index')
            ->with('success', 'denuncia creada correctamente siguiendo el modelo original');
    }
}
