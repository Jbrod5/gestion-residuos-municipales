<?php

namespace App\Http\Controllers\Conductor;

use App\Http\Controllers\Controller;
use App\Services\ConductorService;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    protected $conductorService;

    public function __construct(ConductorService $conductorService)
    {
        $this->conductorService = $conductorService;
    }

    /**
     * Dashboard del conductor con resumen de actividades
     */
    public function dashboard()
    {
        $estadisticas = $this->conductorService->obtenerEstadisticas();
        $asignacionesActivas = $this->conductorService->obtenerMisAsignacionesActivas();
        
        return view('conductor.dashboard', compact('estadisticas', 'asignacionesActivas'));
    }

    /**
     * Lista todas las asignaciones del conductor (historial)
     */
    public function index()
    {
        $asignaciones = $this->conductorService->obtenerMiHistorial();
        
        return view('conductor.asignaciones.index', compact('asignaciones'));
    }

    /**
     * Muestra los detalles de una asignación específica
     */
    public function show($id_asignacion)
    {
        $asignacion = $this->conductorService->obtenerAsignacion($id_asignacion);
        
        return view('conductor.asignaciones.show', compact('asignacion'));
    }

    /**
     * Formulario para iniciar una ruta
     */
    public function iniciar($id_asignacion)
    {
        try {
            $asignacion = $this->conductorService->iniciarRuta($id_asignacion);
            
            return redirect()->route('conductor.asignaciones.show', $id_asignacion)
                ->with('success', 'Ruta iniciada correctamente. ¡Buen trabajo!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al iniciar la ruta: ' . $e->getMessage());
        }
    }

    /**
     * Muestra el formulario para finalizar ruta
     */
    public function editFinalizar($id_asignacion)
    {
        $asignacion = $this->conductorService->obtenerAsignacion($id_asignacion);
        
        // Solo permitir si está en proceso
        if ($asignacion->id_estado_asignacion_ruta != 2) {
            return redirect()->route('conductor.asignaciones.show', $id_asignacion)
                ->with('error', 'Esta ruta no está en proceso');
        }
        
        return view('conductor.asignaciones.finalizar', compact('asignacion'));
    }

    /**
     * Procesa la finalización de la ruta
     */
    public function finalizar(Request $request, $id_asignacion)
    {
        $request->validate([
            'basura_recolectada_ton' => 'required|numeric|min:0|max:100',
            'notas_incidencias' => 'nullable|string|max:500'
        ]);

        try {
            $this->conductorService->finalizarRuta($id_asignacion, $request->all());
            
            return redirect()->route('conductor.asignaciones.show', $id_asignacion)
                ->with('success', 'Ruta finalizada correctamente. ¡Gracias por tu trabajo!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al finalizar la ruta: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * API para obtener puntos de la ruta actual (para mapa en tiempo real)
     */
    public function apiRutaActual()
    {
        $asignacion = AsignacionRuta::with(['ruta.puntosRecoleccion', 'ruta.trayectorias'])
            ->where('id_conductor', Auth::id())
            ->where('id_estado_asignacion_ruta', 2)
            ->first();

        if (!$asignacion) {
            return response()->json(['error' => 'No hay ruta activa'], 404);
        }

        return response()->json([
            'ruta' => $asignacion->ruta,
            'puntos_recoleccion' => $asignacion->ruta->puntosRecoleccion,
            'trayectoria' => $asignacion->ruta->trayectorias
        ]);
    }
}