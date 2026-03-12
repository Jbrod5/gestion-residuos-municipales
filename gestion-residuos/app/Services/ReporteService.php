<?php

namespace App\Services;

use App\Models\AsignacionRuta;
use App\Models\Denuncia;
use App\Models\EntregaReciclaje;
use Illuminate\Support\Facades\DB;

class ReporteService
{
    /**
     * Genera CSV para reporte de recolección
     */
    public function generarCSVRecoleccion($filtros = [])
    {
        $query = AsignacionRuta::with(['ruta', 'camion', 'conductor', 'estado']);

        if (isset($filtros['fecha_desde'])) {
            $query->whereDate('fecha', '>=', $filtros['fecha_desde']);
        }
        if (isset($filtros['fecha_hasta'])) {
            $query->whereDate('fecha', '<=', $filtros['fecha_hasta']);
        }
        if (isset($filtros['estado'])) {
            $query->where('id_estado_asignacion_ruta', $filtros['estado']);
        }

        $data = $query->orderBy('fecha', 'desc')->get();

        $headers = [
            'ID', 'Fecha', 'Ruta', 'Zona', 'Camión', 'Conductor',
            'Estado', 'Basura Estimada (t)', 'Basura Recolectada (t)',
            'Hora Inicio', 'Hora Fin', 'Incidencias'
        ];

        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                $item->id_asignacion_ruta,
                $item->fecha,
                $item->ruta->nombre ?? 'N/A',
                $item->ruta->zona->nombre ?? 'N/A',
                $item->camion->placa ?? 'N/A',
                $item->conductor->nombre ?? 'No asignado',
                $item->estado->nombre ?? 'N/A',
                number_format($item->basura_estimada_ton, 2),
                number_format($item->basura_recolectada_ton ?? 0, 2),
                $item->hora_inicio ?? '—',
                $item->hora_fin ?? '—',
                $item->notas_incidencias ?? ''
            ];
        }

        return $this->generarCSV($headers, $rows, 'recoleccion_' . date('Y-m-d'));
    }

    /**
     * Genera CSV para reporte de denuncias
     */
    public function generarCSVDenuncias($filtros = [])
    {
        $query = Denuncia::with(['usuario', 'estado', 'tamano']);

        if (isset($filtros['estado'])) {
            $query->where('id_estado_denuncia', $filtros['estado']);
        }
        if (isset($filtros['fecha_desde'])) {
            $query->whereDate('created_at', '>=', $filtros['fecha_desde']);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $headers = [
            'ID', 'Denunciante', 'Descripción', 'Tamaño', 'Estado',
            'Fecha', 'Latitud', 'Longitud', 'Foto Antes', 'Foto Después'
        ];

        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                $item->id_denuncia,
                $item->usuario->nombre ?? 'Anónimo',
                $item->descripcion,
                $item->tamano->nombre ?? 'N/A',
                $item->estado->nombre ?? 'N/A',
                $item->created_at->format('d/m/Y H:i'),
                $item->latitud ?? '—',
                $item->longitud ?? '—',
                $item->foto_antes ? asset('storage/' . $item->foto_antes) : 'Sin foto',
                $item->foto_despues ? asset('storage/' . $item->foto_despues) : 'Sin foto'
            ];
        }

        return $this->generarCSV($headers, $rows, 'denuncias_' . date('Y-m-d'));
    }

    /**
     * Genera CSV para reporte de reciclaje
     */
    public function generarCSVReciclaje($filtros = [])
    {
        $query = EntregaReciclaje::with(['puntoVerde', 'material', 'usuario']);

        if (isset($filtros['id_material'])) {
            $query->where('id_material', $filtros['id_material']);
        }
        if (isset($filtros['id_punto_verde'])) {
            $query->where('id_punto_verde', $filtros['id_punto_verde']);
        }

        $data = $query->orderBy('fecha', 'desc')->get();

        $headers = [
            'ID', 'Punto Verde', 'Material', 'Ciudadano',
            'Cantidad (kg)', 'Fecha', 'Observaciones'
        ];

        $rows = [];
        foreach ($data as $item) {
            $rows[] = [
                $item->id_entrega,
                $item->puntoVerde->nombre ?? 'N/A',
                $item->material->nombre ?? 'N/A',
                $item->usuario->nombre ?? 'Visitante',
                number_format($item->cantidad_kg, 2),
                $item->fecha instanceof \Carbon\Carbon ? $item->fecha->format('d/m/Y H:i') : $item->fecha,
                $item->observaciones ?? ''
            ];
        }

        return $this->generarCSV($headers, $rows, 'reciclaje_' . date('Y-m-d'));
    }

    /**
     * Método privado para generar el archivo CSV
     */
    private function generarCSV($headers, $rows, $filename)
    {
        $callback = function() use ($headers, $rows) {
            $file = fopen('php://output', 'w');
            
            // Escribir BOM para UTF-8 (soporte de caracteres especiales)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Escribir encabezados
            fputcsv($file, $headers, ';');
            
            // Escribir filas
            foreach ($rows as $row) {
                fputcsv($file, $row, ';');
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }
}