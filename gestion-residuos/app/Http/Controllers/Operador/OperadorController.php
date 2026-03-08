<?php

namespace App\Http\Controllers\Operador;

use App\Http\Controllers\Controller;
use App\Services\OperadorService;
use App\Models\PuntoVerde;
use App\Models\Material;
use Illuminate\Http\Request;

class OperadorController extends Controller
{
    protected $operadorService;

    public function __construct(OperadorService $operadorService)
    {
        $this->operadorService = $operadorService;
    }

    /**
     * Dashboard del Operador municipal
     */
    public function dashboard()
    {
        $usuario = auth()->user();
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

    /**
     * Formulario de nueva entrega municipal
     */
    public function createEntrega()
    {
        if (!auth()->user()->id_punto_verde) {
            return redirect()->route('operador.dashboard')->with('error', 'No puede registrar entregas sin un Punto Verde asignado municipal.');
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

    /**
     * Solicita vaciado manual municipal
     */
    public function solicitarVaciado($id_contenedor)
    {
        // La lógica automática ya crea la solicitud, esto es un refuerzo municipal
        return redirect()->back()->with('info', 'La solicitud de vaciado ha sido notificada al coordinador municipal.');
    }
}
