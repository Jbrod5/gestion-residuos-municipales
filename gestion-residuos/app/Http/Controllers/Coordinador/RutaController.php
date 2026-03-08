<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Services\RutaService;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    protected $rutaService;

    public function __construct(RutaService $rutaService)
    {
        $this->rutaService = $rutaService;
    }

    /**
     * listado de rutas municipales
     */
    public function index()
    {
        $rutas = $this->rutaService->listarRutas();
        return view('coordinator.rutas.index', compact('rutas'));
    }

    /**
     * formulario con mapa para trazado de ruta success total
     */
    public function create()
    {
        $data = $this->rutaService->obtenerDatosFormulario();
        return view('coordinator.rutas.create', $data);
    }

    /**
     * guarda la ruta y genera los puntos de recoleccion municipal
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_zona' => 'required|exists:zonas,id_zona',
            'id_tipo_residuo' => 'required|exists:tipo_residuos,id_tipo_residuo',
            'poblacion_estimada' => 'nullable|integer|min:0',
            'distancia_km' => 'required|numeric|min:0.01',
            'camino_coordenadas' => 'required|string', // JSON string from Leaflet
            'horarios' => 'nullable|array',
        ]);

        try {
            $this->rutaService->crearRuta($request->all());

            return redirect()->route('coordinator.rutas.index')
                ->with('success', 'ruta municipal trazada y puntos generados exitosamente');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'error al procesar la ruta: ' . $e->getMessage());
        }
    }

    /**
     * detalle de la ruta y sus puntos sembrados  
     */
    public function show($id)
    {
        $ruta = $this->rutaService->obtenerPorId($id);
        return view('coordinator.rutas.show', compact('ruta'));
    }
}