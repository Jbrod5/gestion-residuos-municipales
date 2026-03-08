<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Models\AsignacionRuta;
use App\Models\Ruta;
use App\Models\Usuario;
use App\Services\AsignacionService;
use Illuminate\Http\Request;

class AsignacionController extends Controller
{
    protected $asignacionService;

    public function __construct(AsignacionService $asignacionService)
    {
        $this->asignacionService = $asignacionService;
    }

    public function index(Request $request)
    {
        $query = AsignacionRuta::with(['ruta', 'camion', 'conductor', 'estado']);

        if ($request->filled('fecha')) {
            $query->whereDate('fecha', $request->fecha);
        }

        $asignaciones = $query->orderBy('fecha', 'desc')->paginate(15);
        
        return view('coordinator.asignaciones.index', compact('asignaciones'));
    }

    public function create()
    {
        $rutas = Ruta::with('dias')->get();
        $conductores = Usuario::where('id_rol', 3)->get(); // Suponiendo Rol 3 = Conductor municipal
        $cuadrillas = \App\Models\Cuadrilla::all();
        
        return view('coordinator.asignaciones.create', compact('rutas', 'conductores', 'cuadrillas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruta' => 'required|exists:rutas,id_ruta',
            'id_camion' => 'required|exists:camiones,id_camion',
            'fecha' => 'required|date',
            'id_conductor' => 'nullable|exists:usuarios,id_usuario',
        ]);

        $this->asignacionService->asignarRuta($request->all());

        return redirect()->route('coordinator.asignaciones.index')
            ->with('success', 'Asignación programada correctamente municipal');
    }

    /**
     * API para obtener disponibilidad municipal via AJAX.
     */
    public function apiDisponibilidad(Request $request)
    {
        $fecha = $request->get('fecha');
        $idRuta = $request->get('id_ruta');

        if (!$fecha || !$idRuta) return response()->json([]);

        $camiones = $this->asignacionService->obtenerCamionesDisponibles($fecha, $idRuta);
        $esProgramada = $this->asignacionService->esFechaProgramada($idRuta, $fecha);

        return response()->json([
            'camiones' => $camiones,
            'es_programada' => $esProgramada
        ]);
    }
}
