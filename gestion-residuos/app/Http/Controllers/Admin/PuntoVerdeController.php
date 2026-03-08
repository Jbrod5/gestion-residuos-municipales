<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PuntoVerdeService;
use Illuminate\Http\Request;

class PuntoVerdeController extends Controller
{
    protected $puntoVerdeService;

    public function __construct(PuntoVerdeService $puntoVerdeService)
    {
        $this->puntoVerdeService = $puntoVerdeService;
    }

    /**
     * listado de infraestructura de reciclaje municipal
     */
    public function index()
    {
        $puntos = $this->puntoVerdeService->listarPuntos();
        return view('admin.puntos_verdes.index', compact('puntos'));
    }

    /**
     * formulario de creación con mapa Leaflet y materiales
     */
    public function create()
    {
        $materiales = $this->puntoVerdeService->listarMateriales();
        $operadores = $this->puntoVerdeService->obtenerOperadoresDisponibles();
        return view('admin.puntos_verdes.create', compact('materiales', 'operadores'));
    }

    /**
     * procesa la creación atómica del punto verde y contenedores
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'horario' => 'nullable|string|max:100',
            'capacidad_total_m3' => 'required|numeric|min:1',
            'id_encargado' => 'required|exists:usuarios,id_usuario',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'contenedores' => 'nullable|array',
            'contenedores.*' => 'nullable|numeric|min:0',
        ]);

        try {
            $this->puntoVerdeService->crearPuntoVerde($request->all());

            return redirect()->route('admin.puntos-verdes.index')
                ->with('success', 'punto verde y contenedores municipales creados con éxito absoluto');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'error al crear infraestructura: ' . $e->getMessage());
        }
    }
}
