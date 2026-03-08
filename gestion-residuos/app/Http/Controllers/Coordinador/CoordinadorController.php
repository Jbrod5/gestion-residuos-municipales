<?php

namespace App\Http\Controllers\Coordinador;

use App\Http\Controllers\Controller;
use App\Services\CoordinadorService;
use Illuminate\Http\Request;

class CoordinadorController extends Controller
{
    protected $coordinadorService;

    public function __construct(CoordinadorService $coordinadorService)
    {
        $this->coordinadorService = $coordinadorService;
    }

    // listado de solicitudes de vaciado pendientes
    public function index()
    {
        $solicitudes = $this->coordinadorService->listarSolicitudesPendientes();
        return view('coordinator.solicitudes.index', compact('solicitudes'));
    }

    // atiende una solicitud y ejecuta el vaciado
    public function atender($id_solicitud)
    {
        try {
            $this->coordinadorService->finalizarVaciado($id_solicitud);
            return redirect()->route('coordinator.solicitudes.index')
                ->with('success', 'vaciado confirmado y contenedor reseteado');
        } catch (\Exception $e) {
            return redirect()->route('coordinator.solicitudes.index')
                ->with('error', 'no se pudo procesar el vaciado: ' . $e->getMessage());
        }
    }
}

