<?php

namespace App\Services;

use App\Models\TipoResiduo;
use Illuminate\Support\Facades\DB;

class TipoResiduoService
{
    /**
     * Lista todos los tipos de residuo con paginación
     */
/**
 * Lista todos los tipos de residuo con paginación
 */
public function listar($porPagina = 10)
{
    return TipoResiduo::with('rutas')
              ->paginate($porPagina);
}

    /**
     * Obtiene todos los tipos de residuo (para selects)
     */
    public function obtenerTodos()
    {
        return TipoResiduo::orderBy('nombre')->get();
    }

    /**
     * Crea un nuevo tipo de residuo
     */
    public function crear(array $data)
    {
        return DB::transaction(function () use ($data) {
            return TipoResiduo::create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null
            ]);
        });
    }

    /**
     * Obtiene un tipo de residuo por ID
     */
    public function obtenerPorId($id)
    {
        return TipoResiduo::findOrFail($id);
    }

    /**
     * Actualiza un tipo de residuo existente
     */
    public function actualizar($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tipo = $this->obtenerPorId($id);
            
            $tipo->update([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null
            ]);

            return $tipo;
        });
    }

    /**
     * Elimina un tipo de residuo (verifica que no esté en uso)
     */
    public function eliminar($id)
    {
        return DB::transaction(function () use ($id) {
            $tipo = $this->obtenerPorId($id);
            
            // Verificar si está siendo usado en rutas
            if ($tipo->rutas()->exists()) {
                throw new \Exception('No se puede eliminar porque hay rutas que usan este tipo de residuo');
            }
            
            return $tipo->delete();
        });
    }

    /**
     * Obtiene estadísticas de uso del tipo de residuo
     */
    public function obtenerEstadisticas($id)
    {
        $tipo = $this->obtenerPorId($id);
        
        return [
            'total_rutas' => $tipo->rutas()->count(),
            'total_asignaciones' => $tipo->rutas()->withCount('asignaciones')->get()->sum('asignaciones_count'),
            'ultimo_uso' => $tipo->rutas()->latest('updated_at')->first()?->updated_at
        ];
    }
}