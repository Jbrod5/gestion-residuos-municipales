<?php

namespace App\Services;

use App\Models\EntregaReciclaje;
use App\Models\Contenedor;
use App\Models\SolicitudVaciado;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OperadorService
{
    // registra una entrega de material y actualiza el stock del contenedor
    public function registrarEntrega(array $data)
    {
        return DB::transaction(function () use ($data) {
            $material = Material::findOrFail($data['id_material']);
            $contenedor = Contenedor::where('id_punto_verde', $data['id_punto_verde'])
                ->where('id_material', $data['id_material'])
                ->firstOrFail();

            // conversion: m3 = kg / densidad (kg/m3)
            $volumen_m3 = $data['cantidad_kg'] / $material->densidad_kg_m3;

            // registrar la entrega
            $entrega = EntregaReciclaje::create([
                'id_punto_verde' => $data['id_punto_verde'],
                'id_material' => $data['id_material'],
                'id_usuario' => $data['id_usuario'] ?? null,
                'cantidad_kg' => $data['cantidad_kg'],
                'fecha' => Carbon::now(),
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            // sumar volumen al contenedor
            $contenedor->nivel_actual_m3 += $volumen_m3;
            $contenedor->save();

            // crear solicitud de vaciado automatica si llega a >= 90%
            $porcentaje = ($contenedor->nivel_actual_m3 / $contenedor->capacidad_maxima_m3) * 100;
            if ($porcentaje >= 90) {
                SolicitudVaciado::firstOrCreate(
                    [
                        'id_punto_verde' => $data['id_punto_verde'],
                        'id_contenedor' => $contenedor->id_contenedor,
                        'estado' => 'Pendiente',
                    ],
                    [
                        'id_usuario' => $data['id_usuario'] ?? null,
                        'fecha_solicitud' => Carbon::now(),
                    ]
                );
            }

            return $entrega;
        });
    }

    // obtiene el inventario con niveles de alerta diferenciados (75%, 90%, 100%)
    public function getEstadoInventario($idPuntoVerde)
    {
        return Contenedor::with('material')
            ->where('id_punto_verde', $idPuntoVerde)
            ->get()
            ->map(function ($c) {
                $porcentaje = $c->capacidad_maxima_m3 > 0
                    ? ($c->nivel_actual_m3 / $c->capacidad_maxima_m3) * 100
                    : 0;
                $porcentaje = min($porcentaje, 100);

                $c->porcentaje_llenado = round($porcentaje, 1);

                // estado_alerta determina el color y la accion a mostrar
                if ($porcentaje >= 100) {
                    $c->estado_alerta = 'lleno';       // contenedor lleno, atencion inmediata
                } elseif ($porcentaje >= 90) {
                    $c->estado_alerta = 'critico';    // solicitar vaciado urgente
                } elseif ($porcentaje >= 75) {
                    $c->estado_alerta = 'advertencia'; // alerta temprana
                } else {
                    $c->estado_alerta = 'normal';      // ok
                }

                $c->necesita_vaciado = $porcentaje >= 90;
                return $c;
            });
    }

    // resetea un contenedor y marca la solicitud como atendida
    public function atenderVaciado($idContenedor)
    {
        return DB::transaction(function () use ($idContenedor) {
            $contenedor = Contenedor::findOrFail($idContenedor);
            $volumenAntes = $contenedor->nivel_actual_m3;
            $contenedor->nivel_actual_m3 = 0;
            $contenedor->save();

            SolicitudVaciado::where('id_contenedor', $idContenedor)
                ->where('estado', 'Pendiente')
                ->update([
                    'estado' => 'Atendida',
                    'fecha_atencion' => Carbon::now(),
                    'volumen_m3' => $volumenAntes,
                ]);

            return true;
        });
    }

    // crea una solicitud de vaciado manual desde el boton del operador
    public function crearSolicitudVaciado($idContenedor, $idPuntoVerde, $idUsuario = null)
    {
        return SolicitudVaciado::firstOrCreate(
            [
                'id_punto_verde' => $idPuntoVerde,
                'id_contenedor' => $idContenedor,
                'estado' => 'Pendiente',
            ],
            [
                'id_usuario' => $idUsuario,
                'fecha_solicitud' => Carbon::now(),
            ]
        );
    }

    // obtiene un historial unificado de entradas y vaciados para el kardex del operador
    public function obtenerHistorialMovimientos($idPuntoVerde, $fechaDesde = null, $fechaHasta = null, $limit = 50)
    {
        $desde = $fechaDesde
            ? Carbon::parse($fechaDesde)->startOfDay()
            : Carbon::now()->subWeek()->startOfDay();

        $hasta = $fechaHasta
            ? Carbon::parse($fechaHasta)->endOfDay()
            : Carbon::now()->endOfDay();

        $entregas = EntregaReciclaje::with('material')
            ->where('id_punto_verde', $idPuntoVerde)
            ->whereBetween('fecha', [$desde, $hasta])
            ->get()
            ->map(function ($entrega) {
                $fecha = $entrega->fecha instanceof Carbon
                    ? $entrega->fecha
                    : Carbon::parse($entrega->fecha);

                return (object) [
                    'fecha' => $fecha,
                    'material' => optional($entrega->material)->nombre ?? 'sin material',
                    'movimiento' => 'Entrada',
                    'cantidad_valor' => $entrega->cantidad_kg,
                    'cantidad_unidad' => 'kg',
                    'observaciones' => $entrega->observaciones,
                ];
            });

        $vaciados = SolicitudVaciado::with(['contenedor.material'])
            ->where('id_punto_verde', $idPuntoVerde)
            ->where('estado', 'Atendida')
            ->whereBetween('fecha_atencion', [$desde, $hasta])
            ->get()
            ->map(function ($solicitud) {
                $fecha = $solicitud->fecha_atencion
                    ? Carbon::parse($solicitud->fecha_atencion)
                    : ($solicitud->fecha_solicitud
                        ? Carbon::parse($solicitud->fecha_solicitud)
                        : Carbon::now());

                $materialNombre = optional(optional($solicitud->contenedor)->material)->nombre ?? 'sin material';
                $volumen = $solicitud->volumen_m3
                    ?? optional($solicitud->contenedor)->nivel_actual_m3
                    ?? optional($solicitud->contenedor)->capacidad_maxima_m3
                    ?? 0;

                return (object) [
                    'fecha' => $fecha,
                    'material' => $materialNombre,
                    'movimiento' => 'Salida',
                    'cantidad_valor' => $volumen,
                    'cantidad_unidad' => 'm3',
                    'observaciones' => 'vaciado de contenedor',
                ];
            });

        return $entregas
            ->merge($vaciados)
            ->sortByDesc('fecha')
            ->take($limit)
            ->values();
    }
}
