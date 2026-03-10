<?php

namespace App\Http\Controllers\Ciudadano;

use App\Http\Controllers\Controller;
use App\Models\Ruta;

class RutaPublicaController extends Controller
{
    // muestra la vista principal del mapa de rutas para el ciudadano
    public function index()
    {
        return view('ciudadano.mapa_recoleccion');
    }

    // api simple para exponer rutas con zona dias y trayectoria
    public function apiRutas()
    {
        $rutas = Ruta::with(['zona', 'dias', 'trayectorias'])
            ->get()
            ->map(function (Ruta $ruta) {
                return [
                    'id' => $ruta->id_ruta,
                    'nombre' => $ruta->nombre,
                    'zona' => $ruta->zona?->nombre,
                    'dias' => $ruta->dias->map(function ($dia) {
                        return [
                            'nombre' => $dia->nombre,
                            'hora_inicio' => $dia->pivot->hora_inicio,
                            'hora_fin' => $dia->pivot->hora_fin,
                        ];
                    }),
                    'trayectoria' => $ruta->trayectorias->map(function ($punto) {
                        return [$punto->latitud, $punto->longitud];
                    }),
                ];
            });

        return response()->json($rutas);
    }
}

