<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PuntoVerde;

class PuntoVerdePublicController extends Controller
{
    // muestra el mapa publico de puntos verdes con leaflet
    public function index()
    {
        $puntosVerdes = PuntoVerde::with(['contenedores.material'])
            ->whereNotNull('latitud')
            ->whereNotNull('longitud')
            ->get();

        return view('public.puntos_verdes', compact('puntosVerdes'));
    }
}

