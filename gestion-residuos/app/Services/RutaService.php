<?php

namespace App\Services;

use App\Models\Ruta;
use App\Models\PuntoRecoleccion;
use App\Models\Zona;
use App\Models\TipoResiduo;
use Illuminate\Support\Facades\DB;

class RutaService
{
    /**
     * Lista todas las rutas municipales.
     */
    public function listarRutas()
    {
        return Ruta::with(['zona', 'tipoResiduo'])->get();
    }

    /**
     * Obtiene datos para el formulario de creación.
     */
    public function obtenerDatosFormulario()
    {
        return [
            'zonas' => Zona::with('tipoZona')->get(),
            'tiposResiduo' => TipoResiduo::all(),
            'diasSemana' => \App\Models\DiaSemana::all(),
        ];
    }

    /**
     * Crea una ruta y genera automáticamente sus puntos de recolección.
     */
    public function crearRuta(array $data)
    {
        return DB::transaction(function () use ($data) {
            $coordenadasTrazado = json_decode($data['camino_coordenadas'], true);
            $inicio = $coordenadasTrazado[0] ?? [0,0];
            $fin = end($coordenadasTrazado) ?: [0,0];

            // 1. Crear el registro base de la ruta municipal
            $ruta = Ruta::create([
                'id_zona' => $data['id_zona'],
                'id_tipo_residuo' => $data['id_tipo_residuo'],
                'nombre' => $data['nombre'],
                'distancia_km' => $data['distancia_km'],
                'latitud_inicio' => $inicio[0],
                'longitud_inicio' => $inicio[1],
                'latitud_fin' => $fin[0],
                'longitud_fin' => $fin[1],
            ]);

            // 2. Guardar Horarios (ruta_dia) success total
            if (isset($data['horarios']) && is_array($data['horarios'])) {
                foreach ($data['horarios'] as $id_dia => $horario) {
                    if (isset($horario['seleccionado'])) {
                        $ruta->dias()->attach($id_dia, [
                            'hora_inicio' => $horario['hora_inicio'],
                            'hora_fin' => $horario['hora_fin']
                        ]);
                    }
                }
            }

            // 3. Guardar Trayectoria Relacional success total
            if (is_array($coordenadasTrazado)) {
                foreach ($coordenadasTrazado as $index => $coord) {
                    $ruta->trayectorias()->create([
                        'latitud' => $coord[0],
                        'longitud' => $coord[1],
                        'orden' => $index + 1
                    ]);
                }
            }

            // 4. Algoritmo de Siembra con Pesaje por Zona municipal
            $totalBasura = $this->generarPuntosRecoleccion($ruta);
            
            // 5. Actualizar el total estimado en la ruta rotunda victoria
            $ruta->update(['basura_total_estimada' => $totalBasura]);

            return $ruta;
        });
    }

    /**
     * Lógica de generación dinámica de puntos cerca de la trayectoria.
     */
    private function generarPuntosRecoleccion(Ruta $ruta)
    {
        $trayectorias = $ruta->trayectorias()->orderBy('orden')->get();
        $numPuntos = rand(15, 30);
        $totalTrayectorias = $trayectorias->count();
        $sumaPeso = 0;

        if ($totalTrayectorias === 0) return 0;

        $idTipoZona = $ruta->zona->id_tipo_zona;
        $esAltaCarga = in_array($idTipoZona, [6, 7]);

        for ($i = 0; $i < $numPuntos; $i++) {
            if ($totalTrayectorias > 1) {
                // Seleccionar un segmento aleatorio entre dos puntos consecutivos
                $idx = rand(0, $totalTrayectorias - 2);
                $p1 = $trayectorias[$idx];
                $p2 = $trayectorias[$idx + 1];

                // Interpolación lineal: P = P1 + t * (P2 - P1)
                $t = rand(0, 1000000) / 1000000;
                $lat = $p1->latitud + $t * ($p2->latitud - $p1->latitud);
                $lng = $p1->longitud + $t * ($p2->longitud - $p1->longitud);
            } else {
                $lat = $trayectorias[0]->latitud;
                $lng = $trayectorias[0]->longitud;
            }

            $peso = $esAltaCarga ? rand(500, 2000) : rand(50, 500);
            $sumaPeso += $peso;

            PuntoRecoleccion::create([
                'id_ruta' => $ruta->id_ruta,
                'posicion_orden' => $i + 1,
                'latitud' => $lat,
                'longitud' => $lng,
                'volumen_estimado_kg' => $peso,
            ]);
        }

        return $sumaPeso;
    }

    /**
     * Busca una ruta con sus puntos y trayectoria.
     */
    public function obtenerPorId($id)
    {
        return Ruta::with(['zona', 'tipoResiduo', 'trayectorias', 'puntosRecoleccion', 'dias'])->findOrFail($id);
    }
}