<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ZonaService;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    protected $zonaService;

    public function __construct(ZonaService $zonaService)
    {
        $this->zonaService = $zonaService;
    }

    /**
     * Vista principal con zonas y tipos de zona
     */
    public function index()
    {
        $zonas = $this->zonaService->listarZonas();
        $tiposZona = $this->zonaService->listarTiposZona();
        
        return view('admin.zonas.index', compact('zonas', 'tiposZona'));
    }

    /**
     * Guardar nueva zona
     */
    public function storeZona(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:zonas,nombre',
            'id_tipo_zona' => 'required|exists:tipo_zonas,id_tipo_zona',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
        ]);

        try {
            $this->zonaService->crearZona($request->all());
            
            return redirect()->route('admin.zonas.index')
                ->with('success', 'Zona creada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear zona: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Guardar nuevo tipo de zona
     */
    public function storeTipoZona(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_zonas,nombre',
            'descripcion' => 'nullable|string|max:500',
        ]);

        try {
            $this->zonaService->crearTipoZona($request->all());
            
            return redirect()->route('admin.zonas.index')
                ->with('success', 'Tipo de zona creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear tipo de zona: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * API para obtener datos de una zona (para el mapa)
     */
    public function apiZona($id)
    {
        try {
            $zona = $this->zonaService->obtenerZona($id);
            
            return response()->json([
                'success' => true,
                'zona' => [
                    'id' => $zona->id_zona,
                    'nombre' => $zona->nombre,
                    'tipo' => $zona->tipoZona->nombre,
                    'latitud' => $zona->latitud,
                    'longitud' => $zona->longitud,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Zona no encontrada'
            ], 404);
        }
    }

    /**
     * API para listar todas las zonas (para el mapa)
     */
    public function apiZonas()
    {
        $zonas = $this->zonaService->listarZonas();
        
        return response()->json([
            'success' => true,
            'zonas' => $zonas->map(function ($zona) {
                return [
                    'id' => $zona->id_zona,
                    'nombre' => $zona->nombre,
                    'tipo' => $zona->tipoZona->nombre,
                    'latitud' => $zona->latitud,
                    'longitud' => $zona->longitud,
                ];
            })
        ]);
    }

    /**
     * Eliminar zona
     */
    public function destroyZona($id)
    {
        try {
            $this->zonaService->eliminarZona($id);
            
            return redirect()->route('admin.zonas.index')
                ->with('success', 'Zona eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}