<?php

namespace App\Services;

use App\Models\PuntoVerde;
use App\Models\Contenedor;
use App\Models\Material;
use App\Models\Usuario;
use App\Models\PuntoVerdeHorario;
use App\Models\DiaSemana;
use Illuminate\Support\Facades\DB;

class PuntoVerdeService
{
    /**
     * lista todos los puntos verdes con su encargado municipal
     */
    public function listarPuntos()
    {
        return PuntoVerde::with(['encargado', 'horarios.diaSemana'])->get();
    }

    /**
     * retorna los materiales disponibles para reciclaje
     */
    public function listarMateriales()
    {
        return Material::all();
    }

    /**
     * retorna los días de la semana para el formulario  
     */
    public function obtenerDiasSemana()
    {
        return DiaSemana::all();
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
            // 1. crear el punto verde
            $punto = PuntoVerde::create([
                'id_encargado' => $data['id_encargado'],
                'nombre' => $data['nombre'],
                'direccion' => $data['direccion'],
                'capacidad_total_m3' => $data['capacidad_total_m3'],
                'latitud' => $data['latitud'],
                'longitud' => $data['longitud'],
                'horario' => null,
            ]);

            // 2. asignar el punto verde al usuario encargado en la tabla usuarios
            // esto es lo que permite al operador ver su punto verde en el dashboard
            Usuario::where('id_usuario', $data['id_encargado'])
                ->update(['id_punto_verde' => $punto->id_punto_verde]);

            // 3. persistir horarios normalizados por día
            if (isset($data['dias']) && is_array($data['dias'])) {
                foreach ($data['dias'] as $id_dia => $activo) {
                    if ($activo && !empty($data['hora_inicio'][$id_dia]) && !empty($data['hora_fin'][$id_dia])) {
                        PuntoVerdeHorario::create([
                            'id_punto_verde' => $punto->id_punto_verde,
                            'id_dia_semana' => $id_dia,
                            'hora_inicio' => $data['hora_inicio'][$id_dia],
                            'hora_fin' => $data['hora_fin'][$id_dia],
                        ]);
                    }
                }
            }

            // 4. crear contenedores para los materiales seleccionados
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

    /**
     * actualiza un punto verde y sincroniza sus relaciones municipal  
     */
    public function actualizarPuntoVerde($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $punto = PuntoVerde::findOrFail($id);
            $encargadoAnterior = $punto->id_encargado;

            // 1. actualizar datos básicos del punto verde
            $punto->update([
                'id_encargado' => $data['id_encargado'],
                'nombre' => $data['nombre'],
                'direccion' => $data['direccion'],
                'capacidad_total_m3' => $data['capacidad_total_m3'],
                'latitud' => $data['latitud'],
                'longitud' => $data['longitud'],
            ]);

            // 2. sincronizar id_punto_verde en la tabla usuarios
            // si cambió el encargado, limpiar el anterior y asignar el nuevo
            if ($encargadoAnterior != $data['id_encargado']) {
                Usuario::where('id_usuario', $encargadoAnterior)
                    ->update(['id_punto_verde' => null]);
            }
            Usuario::where('id_usuario', $data['id_encargado'])
                ->update(['id_punto_verde' => $punto->id_punto_verde]);

            // 3. sincronizar horarios (borrar y re-crear)
            $punto->horarios()->delete();
            if (isset($data['dias']) && is_array($data['dias'])) {
                foreach ($data['dias'] as $id_dia => $activo) {
                    if ($activo && !empty($data['hora_inicio'][$id_dia]) && !empty($data['hora_fin'][$id_dia])) {
                        PuntoVerdeHorario::create([
                            'id_punto_verde' => $punto->id_punto_verde,
                            'id_dia_semana' => $id_dia,
                            'hora_inicio' => $data['hora_inicio'][$id_dia],
                            'hora_fin' => $data['hora_fin'][$id_dia],
                        ]);
                    }
                }
            }

            // 4. sincronizar contenedores
            if (isset($data['contenedores']) && is_array($data['contenedores'])) {
                foreach ($data['contenedores'] as $id_material => $capacidad) {
                    if ($capacidad > 0) {
                        Contenedor::updateOrCreate(
                        ['id_punto_verde' => $punto->id_punto_verde, 'id_material' => $id_material],
                        ['capacidad_maxima_m3' => $capacidad]
                        );
                    } else {
                        Contenedor::where('id_punto_verde', $punto->id_punto_verde)
                            ->where('id_material', $id_material)
                            ->delete();
                    }
                }
            }

            return $punto;
        });
    }

    /**
     * elimina un punto verde y sus relaciones en cascada  
     */
    public function eliminarPuntoVerde($id)
    {
        return DB::transaction(function () use ($id) {
            $punto = PuntoVerde::findOrFail($id);
            // la cascada en la DB se encarga de contenedores y horarios municipal
            return $punto->delete();
        });
    }

    /**
     * busca un punto verde con todas sus relaciones  
     */
    public function obtenerPorId($id)
    {
        return PuntoVerde::with(['encargado', 'horarios', 'contenedores.material'])->findOrFail($id);
    }
}