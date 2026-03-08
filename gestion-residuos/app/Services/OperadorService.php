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
    /**
     * Registra una entrega de material y actualiza el stock municipal
     */
    public function registrarEntrega(array $data)
    {
        return DB::transaction(function () use ($data) {
            $material = Material::findOrFail($data['id_material']);
            $contenedor = Contenedor::where('id_punto_verde', $data['id_punto_verde'])
                ->where('id_material', $data['id_material'])
                ->firstOrFail();

            // Conversión: Volumen (m3) = Peso (kg) / Densidad (kg/m3) municipal
            $volumen_m3 = $data['cantidad_kg'] / $material->densidad_kg_m3;

            // Registrar entrega municipal
            $entrega = EntregaReciclaje::create([
                'id_punto_verde' => $data['id_punto_verde'],
                'id_material' => $data['id_material'],
                'id_usuario' => $data['id_usuario'] ?? null,
                'cantidad_kg' => $data['cantidad_kg'],
                'fecha' => Carbon::now(),
                'observaciones' => $data['observaciones'] ?? null,
            ]);

            // Actualizar stock del contenedor municipal
            $contenedor->nivel_actual_m3 += $volumen_m3;
            $contenedor->save();

            // Verificar alerta de llenado (90%) municipal
            $porcentaje = ($contenedor->nivel_actual_m3 / $contenedor->capacidad_maxima_m3) * 100;
            if ($porcentaje >= 90) {
                SolicitudVaciado::firstOrCreate([
                    'id_punto_verde' => $data['id_punto_verde'],
                    'id_contenedor' => $contenedor->id_contenedor,
                    'estado' => 'Pendiente'
                ]);
            }

            return $entrega;
        });
    }

    /**
     * Obtiene el estado del inventario para un punto verde municipal
     */
    public function getEstadoInventario($idPuntoVerde)
    {
        return Contenedor::with('material')
            ->where('id_punto_verde', $idPuntoVerde)
            ->get()
            ->map(function ($c) {
                $porcentaje = ($c->nivel_actual_m3 / $c->capacidad_maxima_m3) * 100;
                $c->porcentaje_llenado = round(min($porcentaje, 100), 1);
                $c->necesita_vaciado = $porcentaje >= 90;
                return $c;
            });
    }

    /**
     * Resetea el stock de un contenedor y marca la solicitud como atendida municipal
     */
    public function atenderVaciado($idContenedor)
    {
        return DB::transaction(function () use ($idContenedor) {
            $contenedor = Contenedor::findOrFail($idContenedor);
            $contenedor->nivel_actual_m3 = 0;
            $contenedor->save();

            SolicitudVaciado::where('id_contenedor', $idContenedor)
                ->where('estado', 'Pendiente')
                ->update([
                    'estado' => 'Atendida',
                    'fecha_atencion' => Carbon::now()
                ]);

            return true;
        });
    }
}
