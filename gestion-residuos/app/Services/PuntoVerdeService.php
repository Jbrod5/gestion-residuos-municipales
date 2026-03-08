<?php

namespace App\Services;

use App\Models\PuntoVerde;
use App\Models\Contenedor;
use App\Models\Material;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class PuntoVerdeService
{
    /**
     * lista todos los puntos verdes con su encargado municipal
     */
    public function listarPuntos()
    {
        return PuntoVerde::with('encargado')->get();
    }

    /**
     * retorna los materiales disponibles para reciclaje
     */
    public function listarMateriales()
    {
        return Material::all();
    }

    /**
     * filtra usuarios con rol de Operador de Punto Verde (ID 3)
     */
    public function obtenerOperadoresDisponibles()
    {
        return Usuario::where('id_rol', 3)->where('activo', 1)->get();
    }

    /**
     * crea un punto verde y sus contenedores de forma atómica success total
     */
    public function crearPuntoVerde(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. crear el punto verde municipal
            $punto = PuntoVerde::create([
                'id_encargado' => $data['id_encargado'],
                'nombre' => $data['nombre'],
                'direccion' => $data['direccion'],
                'horario' => $data['horario'],
                'capacidad_total_m3' => $data['capacidad_total_m3'],
                'latitud' => $data['latitud'],
                'longitud' => $data['longitud'],
            ]);

            // 2. crear contenedores para los materiales seleccionados
            if (isset($data['contenedores']) && is_array($data['contenedores'])) {
                foreach ($data['contenedores'] as $id_material => $capacidad) {
                    if ($capacidad > 0) {
                        Contenedor::create([
                            'id_punto_verde' => $punto->id_punto_verde,
                            'id_material' => $id_material,
                            'capacidad_maxima_m3' => $capacidad,
                            'nivel_actual_m3' => 0
                        ]);
                    }
                }
            }

            return $punto;
        });
    }
}
