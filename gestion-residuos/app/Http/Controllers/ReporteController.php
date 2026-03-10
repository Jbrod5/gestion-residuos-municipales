<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\EntregaReciclaje;
use App\Models\Denuncia;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    // muestra el dashboard de reportes para el administrador
    public function index()
    {
        return view('admin.reportes.dashboard');
    }

    // api para alimentar las graficas de chartjs
    public function apiDatos()
    {
        $basuraPorZona = Zona::with('rutas')
            ->get()
            ->map(function (Zona $zona) {
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
            ->groupBy('id_material')
            ->with('material')
            ->get()
            ->map(function ($entrega) {
                return [
                    'material' => $entrega->material->nombre,
                    'kg' => $entrega->total_kg,
                ];
            });

        $inicio = Carbon::now()->subMonth()->startOfDay();
        $fin = Carbon::now()->endOfDay();

        $denuncias = Denuncia::with('estado')
            ->whereBetween('fecha', [$inicio, $fin])
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

