<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TipoResiduoService;
use Illuminate\Http\Request;

class TipoResiduoController extends Controller
{
    protected $tipoResiduoService;

    public function __construct(TipoResiduoService $tipoResiduoService)
    {
        $this->tipoResiduoService = $tipoResiduoService;
    }

    /**
     * Listado de tipos de residuo
     */
    public function index()
    {
        $tipos = $this->tipoResiduoService->listar();
        return view('admin.tipos-residuo.index', compact('tipos'));
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        return view('admin.tipos-residuo.create');
    }

    /**
     * Guardar nuevo tipo de residuo
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_residuos,nombre',
            'descripcion' => 'nullable|string|max:500'
        ], [
            'nombre.required' => 'El nombre del tipo de residuo es obligatorio',
            'nombre.unique' => 'Ya existe un tipo de residuo con ese nombre'
        ]);

        try {
            $this->tipoResiduoService->crear($request->all());
            
            return redirect()->route('admin.tipos-residuo.index')
                ->with('success', 'Tipo de residuo creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Ver detalles de un tipo de residuo
     */
    public function show($id)
    {
        $tipo = $this->tipoResiduoService->obtenerPorId($id);
        $estadisticas = $this->tipoResiduoService->obtenerEstadisticas($id);
        
        return view('admin.tipos-residuo.show', compact('tipo', 'estadisticas'));
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $tipo = $this->tipoResiduoService->obtenerPorId($id);
        return view('admin.tipos-residuo.edit', compact('tipo'));
    }

    /**
     * Actualizar tipo de residuo
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:tipo_residuos,nombre,' . $id . ',id_tipo_residuo',
            'descripcion' => 'nullable|string|max:500'
        ]);

        try {
            $this->tipoResiduoService->actualizar($id, $request->all());
            
            return redirect()->route('admin.tipos-residuo.index')
                ->with('success', 'Tipo de residuo actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al actualizar: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Eliminar tipo de residuo
     */
    public function destroy($id)
    {
        try {
            $this->tipoResiduoService->eliminar($id);
            
            return redirect()->route('admin.tipos-residuo.index')
                ->with('success', 'Tipo de residuo eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }
}