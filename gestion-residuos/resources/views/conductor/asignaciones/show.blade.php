@extends('layouts.conductor')

@section('title', 'Detalle de Ruta Asignada')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 60vh;
        min-height: 400px;
        border-radius: 12px;
        border: 2px solid #dee2e6;
    }
    .point-card {
        max-height: 400px;
        overflow-y: auto;
    }
    .point-row { 
        cursor: pointer; 
        transition: background 0.2s; 
    }
    .point-row:hover { 
        background-color: rgba(25, 135, 84, 0.1) !important; 
    }
    .estado-badge {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">
                <i class="fas fa-truck text-success me-2"></i>
                Ruta: {{ $asignacion->ruta->nombre }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('conductor.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('conductor.asignaciones.index') }}">Mis Rutas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle de Ruta</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4 text-end">
            @if($asignacion->id_estado_asignacion_ruta == 1)
                <a href="{{ route('conductor.asignaciones.iniciar', $asignacion->id_asignacion_ruta) }}" 
                   class="btn btn-success btn-lg fw-bold"
                   onclick="return confirm('¿Estás listo para iniciar esta ruta?')">
                    <i class="fas fa-play-circle me-2"></i>INICIAR RUTA
                </a>
            @elseif($asignacion->id_estado_asignacion_ruta == 2)
                <a href="{{ route('conductor.asignaciones.finalizar.form', $asignacion->id_asignacion_ruta) }}" 
                   class="btn btn-warning btn-lg fw-bold">
                    <i class="fas fa-flag-checkered me-2"></i>FINALIZAR RUTA
                </a>
            @endif
            <a href="{{ route('conductor.asignaciones.index') }}" class="btn btn-outline-secondary mt-2">
                <i class="fas fa-arrow-left me-1"></i>VOLVER
            </a>
        </div>
    </div>

    <!-- Tarjeta de Información de la Asignación -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <!-- Estado -->
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-info-circle fa-2x text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase">Estado Actual</small>
                                    <h5 class="mb-0">
                                        @if($asignacion->id_estado_asignacion_ruta == 1)
                                            <span class="badge bg-warning text-dark estado-badge">Programada</span>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 2)
                                            <span class="badge bg-success estado-badge">En Proceso</span>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 3)
                                            <span class="badge bg-info estado-badge">Completada</span>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 4)
                                            <span class="badge bg-danger estado-badge">Incompleta</span>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                        </div>

                        <!-- Fecha y Horario -->
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-calendar-alt fa-2x text-info"></i>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase">Fecha Asignada</small>
                                    <h5 class="mb-0">{{ \Carbon\Carbon::parse($asignacion->fecha)->format('d/m/Y') }}</h5>
                                    <small class="text-muted">
                                        @if($asignacion->hora_inicio)
                                            Inicio: {{ $asignacion->hora_inicio }}
                                        @endif
                                        @if($asignacion->hora_fin)
                                            | Fin: {{ $asignacion->hora_fin }}
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Camión -->
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-truck fa-2x text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase">Camión Asignado</small>
                                    <h5 class="mb-0">{{ $asignacion->camion->placa }}</h5>
                                    <small class="text-muted">Capacidad: {{ $asignacion->camion->capacidad_toneladas }} t</small>
                                </div>
                            </div>
                        </div>

                        <!-- Basura Estimada -->
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-danger bg-opacity-10 p-3 me-3">
                                    <i class="fas fa-weight-hanging fa-2x text-danger"></i>
                                </div>
                                <div>
                                    <small class="text-muted text-uppercase">Basura Estimada</small>
                                    <h5 class="mb-0">{{ number_format($asignacion->basura_estimada_ton, 2) }} t</h5>
                                    @if($asignacion->basura_recolectada_ton)
                                        <small class="text-success">Recolectado: {{ number_format($asignacion->basura_recolectada_ton, 2) }} t</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($asignacion->notas_incidencias)
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-warning mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Incidencia registrada:</strong> {{ $asignacion->notas_incidencias }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mapa y Puntos de Recolección -->
    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marked-alt text-success me-2"></i>
                        Recorrido de la Ruta
                    </h5>
                </div>
                <div class="card-body p-3">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-list-ol text-success me-2"></i>
                        Puntos de Recolección ({{ $asignacion->ruta->puntosRecoleccion->count() }})
                    </h5>
                </div>
                <div class="card-body p-0 point-card">
                    <table class="table table-hover mb-0 small">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Ubicación</th>
                                <th class="text-end pe-3">Peso (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asignacion->ruta->puntosRecoleccion as $punto)
                            <tr class="point-row" onclick="resaltarPunto({{ $punto->id_punto_recoleccion }})">
                                <td class="ps-3 fw-bold">{{ $punto->posicion_orden }}</td>
                                <td>
                                    <small>
                                        {{ number_format($punto->latitud, 4) }}<br>
                                        {{ number_format($punto->longitud, 4) }}
                                    </small>
                                </td>
                                <td class="text-end pe-3 fw-bold text-success">
                                    {{ number_format($punto->volumen_estimado_kg, 0) }} kg
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center py-2">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Haz clic en cualquier punto para verlo en el mapa
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Resumen de la Ruta -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                <div class="card-body text-center">
                    <i class="fas fa-weight-hanging fa-3x text-success mb-2"></i>
                    <h3 class="fw-bold">{{ number_format($asignacion->ruta->puntosRecoleccion->sum('volumen_estimado_kg'), 0) }} kg</h3>
                    <p class="text-muted mb-0">Peso Total Estimado</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                <div class="card-body text-center">
                    <i class="fas fa-road fa-3x text-info mb-2"></i>
                    <h3 class="fw-bold">{{ number_format($asignacion->ruta->distancia_km, 2) }} km</h3>
                    <p class="text-muted mb-0">Distancia Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                <div class="card-body text-center">
                    <i class="fas fa-map-pin fa-3x text-warning mb-2"></i>
                    <h3 class="fw-bold">{{ $asignacion->ruta->puntosRecoleccion->count() }}</h3>
                    <p class="text-muted mb-0">Puntos de Recolección</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos de la ruta
        const trayectorias = @json($asignacion->ruta->trayectorias->map(fn($t) => [$t->latitud, $t->longitud]));
        const puntos = @json($asignacion->ruta->puntosRecoleccion);
        
        // Inicializar mapa
        var map = L.map('map');
        
        // Capa base
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        // Dibujar trayectoria de la ruta
        var polyline = L.polyline(trayectorias, {
            color: '#28a745',
            weight: 5,
            opacity: 0.8
        }).addTo(map);
        
        // Almacenar marcadores
        var marcadores = {};
        
        // Dibujar puntos de recolección
        puntos.forEach(p => {
            var marker = L.circleMarker([p.latitud, p.longitud], {
                radius: 8,
                fillColor: "#ffc107",
                color: "#212529",
                weight: 2,
                opacity: 1,
                fillOpacity: 0.9
            }).bindPopup(`
                <b>Punto #${p.posicion_orden}</b><br>
                <b>Peso:</b> ${p.volumen_estimado_kg} kg<br>
                <small>${p.latitud.toFixed(4)}, ${p.longitud.toFixed(4)}</small>
            `).addTo(map);
            
            marcadores[p.id_punto_recoleccion] = marker;
        });
        
        // Marcadores de inicio y fin
        if (trayectorias.length > 0) {
            L.marker(trayectorias[0], {
                icon: L.divIcon({
                    className: 'bg-success text-white rounded-circle text-center',
                    html: '<i class="fas fa-play"></i>',
                    iconSize: [30, 30]
                })
            }).bindPopup('Inicio de Ruta').addTo(map);
            
            L.marker(trayectorias[trayectorias.length - 1], {
                icon: L.divIcon({
                    className: 'bg-danger text-white rounded-circle text-center',
                    html: '<i class="fas fa-stop"></i>',
                    iconSize: [30, 30]
                })
            }).bindPopup('Fin de Ruta').addTo(map);
        }
        
        // Función para resaltar punto
        window.resaltarPunto = function(id) {
            // Resetear todos los puntos
            puntos.forEach(p => {
                if (marcadores[p.id_punto_recoleccion]) {
                    marcadores[p.id_punto_recoleccion].setStyle({
                        fillColor: "#ffc107",
                        radius: 8,
                        weight: 2
                    });
                }
            });
            
            // Resaltar el seleccionado
            var m = marcadores[id];
            if (m) {
                m.setStyle({
                    fillColor: "#28a745",
                    radius: 12,
                    weight: 3
                });
                m.openPopup();
                map.setView(m.getLatLng(), 17);
            }
        };
        
        // Ajustar vista del mapa
        if (trayectorias.length > 0) {
            map.fitBounds(polyline.getBounds(), { padding: [50, 50] });
        }
    });
</script>
@endpush