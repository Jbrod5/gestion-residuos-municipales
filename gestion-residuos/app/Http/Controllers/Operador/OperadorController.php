<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\OperadorService;
use App\Models\PuntoVerde;
use App\Models\Material;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OperadorController extends Controller
{
    protected $operadorService;

    public function __construct(OperadorService $operadorService)
    {
        $this->operadorService = $operadorService;
    }

    // dashboard principal del operador
    public function dashboard()
    {
        // fresh() recarga el usuario desde la BD, evitando problemas de cache municipal
        $usuario = auth()->user()->fresh();
        $idPuntoVerde = $usuario->id_punto_verde;

        if (!$idPuntoVerde) {
            $puntoVerde = null;
            $inventario = collect();
            return view('operador.dashboard', compact('puntoVerde', 'inventario'));
        }

        $puntoVerde = PuntoVerde::findOrFail($idPuntoVerde);
        $inventario = $this->operadorService->getEstadoInventario($idPuntoVerde);

        return view('operador.dashboard', compact('puntoVerde', 'inventario'));
    }

    // formulario de nueva entrega municipal
    public function createEntrega()
    {
        // fresh() garantiza que tengamos el id_punto_verde actualizado
        if (!auth()->user()->fresh()->id_punto_verde) {
            return redirect()->route('operador.dashboard')->with('error', 'No puede registrar entregas sin un Punto Verde asignado.');
        }

        $materiales = Material::all();
        return view('operador.registrar_entrega', compact('materiales'));
    }

    /**
     * Procesa la entrega municipal
     */
    public function storeEntrega(Request $request)
    {
        $request->validate([
            'id_material' => 'required|exists:materiales,id_material',
            'cantidad_kg' => 'required|numeric|min:0.1',
            'observaciones' => 'nullable|string'
        ]);

        $data = $request->all();
        $data['id_punto_verde'] = auth()->user()->id_punto_verde;
        $data['id_usuario'] = auth()->id();

        $this->operadorService->registrarEntrega($data);

        return redirect()->route('operador.dashboard')->with('success', 'Entrega registrada con éxito municipal.');
    }

    // solicita vaciado de un contenedor específico municipal
    public function solicitarVaciado($id_contenedor)
    {
        $usuario = auth()->user()->fresh();
        $this->operadorService->crearSolicitudVaciado(
            $id_contenedor,
            $usuario->id_punto_verde,
            $usuario->id_usuario ?? $usuario->id
        );
        return redirect()->back()->with('success', 'Solicitud de vaciado enviada al coordinador.');
    }

    // historial unificado de movimientos (kardex) del punto verde
    public function historial(Request $request)
    {
        $usuario = auth()->user()->fresh();

        if (!$usuario->id_punto_verde) {
            return redirect()->route('operador.dashboard')
                ->with('error', 'No puede ver historial sin un Punto Verde asignado.');
        }

        $porDefectoHasta = Carbon::now()->toDateString();
        $porDefectoDesde = Carbon::now()->subWeek()->toDateString();

        $fechaDesde = $request->input('fecha_desde', $porDefectoDesde);
        $fechaHasta = $request->input('fecha_hasta', $porDefectoHasta);

        if ($fechaDesde > $fechaHasta) {
            $tmp = $fechaDesde;
            $fechaDesde = $fechaHasta;
            $fechaHasta = $tmp;
        }

        $historial = $this->operadorService->obtenerHistorialMovimientos(
            $usuario->id_punto_verde,
            $fechaDesde,
            $fechaHasta,
            50
        );

        return view('operador.historial.index', [
            'historial' => $historial,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ]);
    }
}
