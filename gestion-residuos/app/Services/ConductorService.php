<?php

namespace App\Services;

use App\Models\AsignacionRuta;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConductorService
{
    /**
     * Obtiene las asignaciones activas del conductor autenticado
     */
    public function obtenerMisAsignacionesActivas()
    {
        return AsignacionRuta::with(['ruta', 'camion', 'estado'])
            ->where('id_conductor', Auth::id())
            ->whereIn('id_estado_asignacion_ruta', [1, 2]) // 1=Programada, 2=En proceso
            ->orderBy('fecha', 'asc')
            ->get();
    }

    /**
     * Obtiene el historial completo de asignaciones del conductor
     */
    public function obtenerMiHistorial()
    {
        return AsignacionRuta::with(['ruta', 'camion', 'estado'])
            ->where('id_conductor', Auth::id())
            ->orderBy('fecha', 'desc')
            ->paginate(15);
    }

    /**
     * Obtiene una asignación específica del conductor
     */
    public function obtenerAsignacion($id_asignacion)
    {
        return AsignacionRuta::with(['ruta.puntosRecoleccion', 'camion', 'estado'])
            ->where('id_conductor', Auth::id())
            ->where('id_asignacion_ruta', $id_asignacion)
            ->firstOrFail();
    }

    /**
     * Inicia una ruta (cambia estado a "En proceso")
     */
    public function iniciarRuta($id_asignacion)
    {
        return DB::transaction(function () use ($id_asignacion) {
            $asignacion = $this->obtenerAsignacion($id_asignacion);
            
            // Validar que esté en estado "Programada" (ID 1)
            if ($asignacion->id_estado_asignacion_ruta != 1) {
                throw new \Exception('Esta ruta no puede ser iniciada');
            }

            $asignacion->update([
                'id_estado_asignacion_ruta' => 2, // En proceso
                'hora_inicio' => now()->format('H:i:s')
            ]);

            return $asignacion;
        });
    }

    /**
     * Finaliza una ruta registrando basura recolectada e incidencias
     */
    public function finalizarRuta($id_asignacion, array $data)
    {
        return DB::transaction(function () use ($id_asignacion, $data) {
            $asignacion = $this->obtenerAsignacion($id_asignacion);
            
            // Validar que esté en estado "En proceso" (ID 2)
            if ($asignacion->id_estado_asignacion_ruta != 2) {
                throw new \Exception('Solo puedes finalizar rutas en proceso');
            }

            // Validar que la basura no exceda la capacidad del camión
            if ($data['basura_recolectada_ton'] > $asignacion->camion->capacidad_toneladas) {
                throw new \Exception('La basura recolectada excede la capacidad del camión');
            }

            $asignacion->update([
                'id_estado_asignacion_ruta' => 3, // Completada
                'hora_fin' => now()->format('H:i:s'),
                'basura_recolectada_ton' => $data['basura_recolectada_ton'],
                'notas_incidencias' => $data['notas_incidencias'] ?? null
            ]);

            return $asignacion;
        });
    }

    /**
     * Registra una incidencia sin finalizar la ruta
     */
    public function registrarIncidencia($id_asignacion, $incidencia)
    {
        $asignacion = $this->obtenerAsignacion($id_asignacion);
        
        $asignacion->update([
            'notas_incidencias' => $incidencia
        ]);

        return $asignacion;
    }

    /**
     * Verifica si el conductor tiene rutas pendientes para hoy
     */
    public function tieneRutasHoy()
    {
        return AsignacionRuta::where('id_conductor', Auth::id())
            ->whereDate('fecha', now())
            ->whereIn('id_estado_asignacion_ruta', [1, 2])
            ->exists();
    }

    /**
     * Obtiene estadísticas del conductor para su dashboard
     */
    public function obtenerEstadisticas()
    {
        $conductorId = Auth::id();
        
        return [
            'rutas_completadas' => AsignacionRuta::where('id_conductor', $conductorId)
                ->where('id_estado_asignacion_ruta', 3)
                ->count(),
            'total_basura_recolectada' => AsignacionRuta::where('id_conductor', $conductorId)
                ->where('id_estado_asignacion_ruta', 3)
                ->sum('basura_recolectada_ton'),
            'ruta_actual' => AsignacionRuta::with('ruta')
                ->where('id_conductor', $conductorId)
                ->where('id_estado_asignacion_ruta', 2)
                ->first(),
            'proxima_ruta' => AsignacionRuta::with('ruta')
                ->where('id_conductor', $conductorId)
                ->where('id_estado_asignacion_ruta', 1)
                ->whereDate('fecha', '>=', now())
                ->orderBy('fecha', 'asc')
                ->first()
        ];
    }
}