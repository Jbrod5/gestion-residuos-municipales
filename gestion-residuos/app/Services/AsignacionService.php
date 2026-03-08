<?php

namespace App\Services;

use App\Models\AsignacionRuta;
use App\Models\Camion;
use App\Models\Ruta;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AsignacionService
{
    /**
     * Obtiene camiones disponibles para una fecha y ruta específica municipal.
     */
    public function obtenerCamionesDisponibles($fecha, $idRuta)
    {
        $ruta = Ruta::findOrFail($idRuta);
        $basuraEstimadaTon = $ruta->basura_total_estimada / 1000; // KG a Ton

        // Camiones que:
        // 1. Estén en estado 'Disponible' (ID 1)
        // 2. Tengan capacidad suficiente
        // 3. No tengan otra asignación en esa fecha
        return Camion::where('id_estado_camion', 1)
            ->where('capacidad_toneladas', '>=', $basuraEstimadaTon)
            ->whereDoesntHave('asignaciones', function ($query) use ($fecha) {
                $query->whereDate('fecha', $fecha);
            })
            ->get();
    }

    /**
     * Registra una nueva asignación de ruta municipal.
     */
    public function asignarRuta(array $data)
    {
        return DB::transaction(function () use ($data) {
            $ruta = Ruta::findOrFail($data['id_ruta']);
            
            // Estado 1 = Programada (según lógica estándar de sistema)
            return AsignacionRuta::create([
                'id_ruta' => $data['id_ruta'],
                'id_camion' => $data['id_camion'],
                'id_conductor' => $data['id_conductor'] ?? null,
                'id_cuadrilla' => $data['id_cuadrilla'] ?? null, // Podría venir de relación camión-cuadrilla
                'fecha' => $data['fecha'],
                'id_estado_asignacion_ruta' => 1, 
                'basura_estimada_ton' => $ruta->basura_total_estimada / 1000,
                'hora_inicio' => $data['hora_inicio'] ?? null,
                'hora_fin' => $data['hora_fin'] ?? null,
                'notas_incidencias' => $data['notas_incidencias'] ?? null,
            ]);
        });
    }

    /**
     * Verifica si la fecha coincide con los días programados municipal.
     */
    public function esFechaProgramada($idRuta, $fecha)
    {
        $diaSemanaMap = [
            0 => 7, // Domingo (Carbon 0 -> DB 7)
            1 => 1, // Lunes
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6
        ];

        $fechaCarbon = Carbon::parse($fecha);
        $idDia = $diaSemanaMap[$fechaCarbon->dayOfWeek];

        return DB::table('ruta_dia')
            ->where('id_ruta', $idRuta)
            ->where('id_dia_semana', $idDia)
            ->exists();
    }
}
