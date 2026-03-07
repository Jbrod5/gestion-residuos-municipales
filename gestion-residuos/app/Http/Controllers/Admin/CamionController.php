<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LogisticaService;
use App\Models\EstadoCamion;
use App\Models\Camion;
use Illuminate\Http\Request;

class CamionController extends Controller
{
    protected $logisticaService;

    public function __construct(LogisticaService $logisticaService)
    {
        $this->logisticaService = $logisticaService;
    }

    // listado de la flota municipal guatemalteca 2026
    public function index()
    {
        $camiones = Camion::with('estado')->get();
        return view('admin.camiones.index', compact('camiones'));
    }

    // formulario para registrar nuevo camión municipal  
    public function create()
    {
        $estados = EstadoCamion::all();
        return view('admin.camiones.create', compact('estados'));
    }

    // procesa el registro del vehículo municipal  
    public function store(Request $request)
    {
        $request->validate([
            'placa' => 'required|string|max:10|unique:camiones,placa',
            'id_estado_camion' => 'required|exists:estado_camiones,id_estado_camion',
            'capacidad_toneladas' => 'required|numeric|min:0.1',
        ]);

        $this->logisticaService->crearCamion($request->all());

        return redirect()->route('admin.camiones.index')
            ->with('success', 'camión municipal registrado exitosamente  ');
    }

    // muestra formulario para editar camión municipal  
    public function edit($id)
    {
        $camion = Camion::findOrFail($id);
        $estados = EstadoCamion::all();
        return view('admin.camiones.edit', compact('camion', 'estados'));
    }

    // actualiza los datos del vehículo operativo municipal  
    public function update(Request $request, $id)
    {
        $camion = Camion::findOrFail($id);

        $request->validate([
            'placa' => 'required|string|max:10|unique:camiones,placa,' . $id . ',id_camion',
            'id_estado_camion' => 'required|exists:estado_camiones,id_estado_camion',
            'capacidad_toneladas' => 'required|numeric|min:0.1',
        ]);

        $camion->update($request->all());

        return redirect()->route('admin.camiones.index')
            ->with('success', 'datos del camión municipal actualizados  ');
    }
}