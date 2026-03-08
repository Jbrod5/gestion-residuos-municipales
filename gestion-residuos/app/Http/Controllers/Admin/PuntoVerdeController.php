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
        $diasSemana = $this->puntoVerdeService->obtenerDiasSemana();
        return view('admin.puntos_verdes.create', compact('materiales', 'operadores', 'diasSemana'));
    }

    /**
     * procesa la creación atómica del punto verde y contenedores
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'capacidad_total_m3' => 'required|numeric|min:1',
            'id_encargado' => 'required|exists:usuarios,id_usuario',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'dias' => 'nullable|array',
            'hora_inicio' => 'nullable|array',
            'hora_fin' => 'nullable|array',
            'contenedores' => 'nullable|array',
            'contenedores.*' => 'nullable|numeric|min:0',
        ]);

        try {
            $this->puntoVerdeService->crearPuntoVerde($request->all());

            return redirect()->route('admin.puntos-verdes.index')
                ->with('success', 'punto verde y contenedores municipales creados correctamente');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'error al crear infraestructura: ' . $e->getMessage());
        }
    }

    /**
     * formulario de edición con mapa Leaflet sincronizado
     */
    public function edit($id)
    {
        $punto = $this->puntoVerdeService->obtenerPorId($id);
        $materiales = $this->puntoVerdeService->listarMateriales();
        $operadores = $this->puntoVerdeService->obtenerOperadoresDisponibles();
        $diasSemana = $this->puntoVerdeService->obtenerDiasSemana();

        // mapear horarios para fácil acceso en la vista municipal success total
        $horariosActivos = $punto->horarios->keyBy('id_dia_semana');
        $contenedoresActivos = $punto->contenedores->keyBy('id_material');

        return view('admin.puntos_verdes.edit', compact(
            'punto', 'materiales', 'operadores', 'diasSemana', 'horariosActivos', 'contenedoresActivos'
        ));
    }

    /**
     * actualiza la infraestructura
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:500',
            'capacidad_total_m3' => 'required|numeric|min:1',
            'id_encargado' => 'required|exists:usuarios,id_usuario',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
            'dias' => 'nullable|array',
            'hora_inicio' => 'nullable|array',
            'hora_fin' => 'nullable|array',
            'contenedores' => 'nullable|array',
            'contenedores.*' => 'nullable|numeric|min:0',
        ]);

        try {
            $this->puntoVerdeService->actualizarPuntoVerde($id, $request->all());

            return redirect()->route('admin.puntos-verdes.index')
                ->with('success', 'infraestructura municipal actualizada correctamente');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'error al actualizar: ' . $e->getMessage());
        }
    }

    /**
     * borrado físico en cascada de la infraestructura
     */
    public function destroy($id)
    {
        try {
            $this->puntoVerdeService->eliminarPuntoVerde($id);
            return redirect()->route('admin.puntos-verdes.index')
                ->with('success', 'infraestructura eliminada correctamente');
        }
        catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'error al eliminar: ' . $e->getMessage());
        }
    }
}