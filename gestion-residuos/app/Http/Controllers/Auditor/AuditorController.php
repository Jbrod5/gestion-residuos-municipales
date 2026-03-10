<?php

namespace App\Http\Controllers\Auditor;

use App\Http\Controllers\Controller;
use App\Models\AsignacionRuta;
use App\Models\Camion;
use App\Models\EntregaReciclaje;
use App\Models\PuntoVerde;
use App\Models\Contenedor;
use App\Models\Denuncia;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuditorController extends Controller
{
    // vista principal de auditoria con graficas y tablas de fiscalizacion
    public function index(Request $request)
    {
        $fechaInicio = $request->query('desde', Carbon::now()->subMonth()->format('Y-m-d'));
        $fechaFin = $request->query('hasta', Carbon::now()->format('Y-m-d'));

        $asignaciones = AsignacionRuta::with(['ruta.zona', 'camion.estado', 'estado'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderByDesc('fecha')
            ->limit(50)
            ->get();

        $camiones = Camion::with('estado')->get();

        $entregas = EntregaReciclaje::with(['puntoVerde', 'material'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderByDesc('fecha')
            ->limit(50)
            ->get();

        $puntosVerdes = PuntoVerde::with('contenedores.material')->get();

        $denuncias = Denuncia::with(['estado', 'usuario', 'tamano'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderByDesc('fecha')
            ->limit(50)
            ->get();

        return view('auditor.dashboard', compact(
            'fechaInicio',
            'fechaFin',
            'asignaciones',
            'camiones',
            'entregas',
            'puntosVerdes',
            'denuncias'
        ));
    }

    // muestra detalles de una asignacion de ruta o de una denuncia segun el tipo
    public function show(string $tipo, int $id)
    {
        if ($tipo === 'asignacion') {
            $asignacion = AsignacionRuta::with(['ruta.zona', 'camion.estado', 'cuadrilla', 'conductor', 'estado'])
                ->findOrFail($id);

            return view('auditor.detalle_asignacion', compact('asignacion'));
        }

        if ($tipo === 'denuncia') {
            $denuncia = Denuncia::with(['estado', 'usuario', 'tamano'])
                ->findOrFail($id);

            return view('auditor.detalle_denuncia', compact('denuncia'));
        }

        abort(404);
    }
}

