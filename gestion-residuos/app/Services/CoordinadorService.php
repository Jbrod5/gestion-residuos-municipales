<?php

namespace App\Services;

use App\Models\SolicitudVaciado;
use App\Models\Contenedor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoordinadorService
{
    // finaliza un vaciado completo desde una solicitud
    public function finalizarVaciado($idSolicitud)
    {
        return DB::transaction(function () use ($idSolicitud) {
            $solicitud = SolicitudVaciado::lockForUpdate()->findOrFail($idSolicitud);

            $contenedor = Contenedor::lockForUpdate()->findOrFail($solicitud->id_contenedor);
            $volumenAntes = $contenedor->nivel_actual_m3;

            // resetear contenedor
            $contenedor->nivel_actual_m3 = 0;
            $contenedor->save();

            // actualizar solicitud
            $solicitud->estado = 'Atendida';
            $solicitud->fecha_atencion = Carbon::now();
            $solicitud->volumen_m3 = $volumenAntes;
            $solicitud->save();

            return $solicitud;
        });
    }

    // obtener listado de solicitudes pendientes con relaciones basicas
    public function listarSolicitudesPendientes()
    {
        return SolicitudVaciado::with(['puntoVerde', 'contenedor.material'])
            ->where('estado', 'Pendiente')
            ->orderBy('fecha_solicitud', 'asc')
            ->get();
    }
}

