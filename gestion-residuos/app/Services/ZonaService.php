<?php

namespace App\Services;

use App\Models\Zona;
use App\Models\TipoZona;
use Illuminate\Support\Facades\DB;

class ZonaService
{
    /**
     * Lista todas las zonas con su tipo
     */
    public function listarZonas()
    {
        return Zona::with('tipoZona')->orderBy('nombre')->get();
    }

    /**
     * Lista todos los tipos de zona
     */
    public function listarTiposZona()
    {
        return TipoZona::orderBy('nombre')->get();
    }

    /**
     * Obtiene datos para el formulario (tipos de zona)
     */
    public function obtenerDatosFormulario()
    {
        return [
            'tiposZona' => $this->listarTiposZona(),
        ];
    }

    /**
     * Crea una nueva zona
     */
    public function crearZona(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Zona::create([
                'id_tipo_zona' => $data['id_tipo_zona'],
                'nombre' => $data['nombre'],
                'latitud' => $data['latitud'] ?? null,
                'longitud' => $data['longitud'] ?? null,
            ]);
        });
    }

    /**
     * Crea un nuevo tipo de zona
     */
    public function crearTipoZona(array $data)
    {
        return DB::transaction(function () use ($data) {
            return TipoZona::create([
                'nombre' => $data['nombre'],
                'descripcion' => $data['descripcion'] ?? null,
            ]);
        });
    }

    /**
     * Obtiene una zona por ID
     */
    public function obtenerZona($id)
    {
        return Zona::with('tipoZona')->findOrFail($id);
    }

    /**
     * Actualiza una zona
     */
    public function actualizarZona($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $zona = $this->obtenerZona($id);
            
            $zona->update([
                'id_tipo_zona' => $data['id_tipo_zona'],
                'nombre' => $data['nombre'],
                'latitud' => $data['latitud'] ?? $zona->latitud,
                'longitud' => $data['longitud'] ?? $zona->longitud,
            ]);

            return $zona;
        });
    }

    /**
     * Elimina una zona (verifica que no esté en uso)
     */
    public function eliminarZona($id)
    {
        return DB::transaction(function () use ($id) {
            $zona = $this->obtenerZona($id);
            
            // Verificar si tiene rutas asociadas
            if ($zona->rutas()->exists()) {
                throw new \Exception('No se puede eliminar la zona porque tiene rutas asociadas');
            }
            
            // Verificar si tiene cuadrillas asociadas
            if ($zona->cuadrillas()->exists()) {
                throw new \Exception('No se puede eliminar la zona porque tiene cuadrillas asociadas');
            }
            
            return $zona->delete();
        });
    }
}