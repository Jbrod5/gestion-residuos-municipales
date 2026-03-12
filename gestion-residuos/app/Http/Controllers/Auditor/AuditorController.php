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
use App\Services\ReporteService;
use App\Models\Zona;
use Illuminate\Support\Facades\DB;

class AuditorController extends Controller
{
    protected $reporteService;

    public function __construct(ReporteService $reporteService)
    {
        $this->reporteService = $reporteService;
    }

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

    /**
     * Exportar recolecciones a CSV
     */
    public function exportarRecoleccion(Request $request)
    {
        return $this->reporteService->generarCSVRecoleccion($request->all());
    }

    /**
     * Exportar denuncias a CSV
     */
    public function exportarDenuncias(Request $request)
    {
        return $this->reporteService->generarCSVDenuncias($request->all());
    }

    /**
     * Exportar reciclaje a CSV
     */
    public function exportarReciclaje(Request $request)
    {
        return $this->reporteService->generarCSVReciclaje($request->all());
    }

    // Agregar este método
    public function apiDatos(Request $request)
    {
        $fechaInicio = $request->query('desde', Carbon::now()->subMonth()->format('Y-m-d'));
        $fechaFin = $request->query('hasta', Carbon::now()->format('Y-m-d'));

        $basuraPorZona = Zona::with('rutas')
            ->get()
            ->map(function ($zona) {
                $kg = $zona->rutas->sum('basura_total_estimada');
                return [
                    'zona' => $zona->nombre,
                    'toneladas' => round($kg / 1000, 2),
                ];
            });

        $materialReciclado = EntregaReciclaje::select(
            'id_material',
            DB::raw('SUM(cantidad_kg) as total_kg')
        )
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->groupBy('id_material')
            ->with('material')
            ->get()
            ->map(function ($entrega) {
                return [
                    'material' => $entrega->material->nombre,
                    'kg' => $entrega->total_kg,
                ];
            });

        $denuncias = Denuncia::with('estado')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->get();

        $porDia = [];
        foreach ($denuncias as $denuncia) {
            $dia = Carbon::parse($denuncia->fecha)->format('Y-m-d');
            if (!isset($porDia[$dia])) {
                $porDia[$dia] = ['recibidas' => 0, 'atendidas' => 0];
            }
            $porDia[$dia]['recibidas']++;
            if ($denuncia->estado && $denuncia->estado->nombre === 'Atendida') {
                $porDia[$dia]['atendidas']++;
            }
        }

        ksort($porDia);
        $fechas = array_keys($porDia);
        $recibidas = array_column($porDia, 'recibidas');
        $atendidas = array_column($porDia, 'atendidas');

        return response()->json([
            'basuraPorZona' => $basuraPorZona,
            'materialReciclado' => $materialReciclado,
            'denunciasSerie' => [
                'fechas' => $fechas,
                'recibidas' => $recibidas,
                'atendidas' => $atendidas,
            ],
        ]);
    }
}

