<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Ruta;
use App\Models\PuntoVerde;
use Illuminate\Http\Request;

class MapaController extends Controller
{
    /**
     * Mapa público de rutas de recolección
     */
    public function mapaRecoleccion()
    {
        return view('public.mapa_recoleccion');
    }

    /**
     * API pública para obtener rutas
     */
    public function apiRutas()
    {
        $rutas = Ruta::with(['zona', 'dias', 'trayectorias'])
            ->get()
            ->map(function ($ruta) {
                return [
                    'id' => $ruta->id_ruta,
                    'nombre' => $ruta->nombre,
                    'zona' => $ruta->zona->nombre ?? null,
                    'dias' => $ruta->dias->map(function ($dia) {
                        return [
                            'nombre' => $dia->nombre,
                            'hora_inicio' => $dia->pivot->hora_inicio,
                            'hora_fin' => $dia->pivot->hora_fin
                        ];
                    }),
                    'trayectoria' => $ruta->trayectorias->map(function ($t) {
                        return [$t->latitud, $t->longitud];
                    })
                ];
            });

        return response()->json($rutas);
    }

    /**
     * Mapa público de puntos verdes
     */
    public function puntosVerdes()
    {
        return view('public.puntos_recoleccion');
    }

    /**
     * API pública para obtener puntos verdes
     */
    public function apiPuntosVerdes()
    {
        $puntos = PuntoVerde::with(['contenedores.material'])
            ->get()
            ->map(function ($punto) {
                return [
                    'id' => $punto->id_punto_verde,
                    'nombre' => $punto->nombre,
                    'direccion' => $punto->direccion,
                    'horario' => $punto->horario,
                    'latitud' => $punto->latitud,
                    'longitud' => $punto->longitud,
                    'contenedores' => $punto->contenedores->map(function ($c) {
                        return [
                            'material' => $c->material ? ['nombre' => $c->material->nombre] : null
                        ];
                    })
                ];
            });

        return response()->json($puntos);
    }
}