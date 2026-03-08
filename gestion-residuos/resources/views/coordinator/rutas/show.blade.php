@extends('layouts.coordinator')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 85vh;
        min-height: 600px;
        border-radius: 12px;
        border: 2px solid #dee2e6;
    }

    .point-card {
        max-height: 480px;
        overflow-y: auto;
    }
    .point-row { cursor: pointer; transition: background 0.2s; }
    .point-row:hover { background-color: rgba(25, 135, 84, 0.1) !important; }
</style>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold"><i class="bi bi-geo-alt-fill text-warning me-2"></i>Detalle de Ruta: {{ $ruta->nombre }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('coordinator.rutas.index') }}">Rutas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $ruta->nombre }}</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('coordinator.rutas.index') }}" class="btn btn-outline-dark fw-bold">
                <i class="bi bi-arrow-left me-1"></i> VOLVER AL LISTADO
            </a>
        </div>
    </div>

    <!-- Resumen Logístico Refinado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-light p-3 border-start border-4 border-warning">
                <p class="mb-0 fw-bold text-dark">
                    <i class="bi bi-info-circle-fill text-warning me-2"></i>
                    Esta ruta inicia en <span class="text-primary">[{{ number_format($ruta->latitud_inicio, 4) }}, {{ number_format($ruta->longitud_inicio, 4) }}]</span>, 
                    termina en <span class="text-primary">[{{ number_format($ruta->latitud_fin, 4) }}, {{ number_format($ruta->longitud_fin, 4) }}]</span>, 
                    recorre <span class="text-dark">{{ number_format($ruta->distancia_km, 2) }} km</span> 
                    y se espera recolectar <span class="text-success">{{ number_format($ruta->basura_total_estimada ?? $ruta->pesoTotalEstimadoKg(), 0) }} kg</span> 
                    los días <span class="badge bg-dark">{{ $ruta->dias->pluck('nombre')->join(', ') ?: 'No definidos' }}</span>.
                </p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div id="map" class="shadow-sm"></div>

            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-white p-3 text-center">
                        <small class="text-muted text-uppercase fw-bold pb-2 border-bottom">Peso Estimado Total</small>
                        <h3 class="fw-bold mt-2 text-warning">{{
                            number_format($ruta->puntosRecoleccion->sum('volumen_estimado_kg'), 0) }} kg</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-white p-3 text-center">
                        <small class="text-muted text-uppercase fw-bold pb-2 border-bottom">Distancia Trazada</small>
                        <h3 class="fw-bold mt-2 text-dark">{{ number_format($ruta->distancia_km, 2) }} km</h3>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 bg-white p-3 text-center">
                        <small class="text-muted text-uppercase fw-bold pb-2 border-bottom">Puntos Generados</small>
                        <h3 class="fw-bold mt-2 text-info">{{ $ruta->puntosRecoleccion->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="bi bi-list-stars me-2"></i>Puntos de Recolección (Sembrados)
                </div>
                <div class="card-body p-0 point-card">
                    <table class="table table-sm table-hover mb-0 small">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Coordenadas</th>
                                <th class="text-end pe-3">Peso (kg)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ruta->puntosRecoleccion as $punto)
                            <tr class="point-row" onclick="resaltarPunto({{ $punto->id_punto_recoleccion }})">
                                <td class="ps-3 fw-bold">{{ $punto->posicion_orden }}</td>
                                <td>{{ number_format($punto->latitud, 4) }}, {{ number_format($punto->longitud, 4) }}
                                </td>
                                <td class="text-end pe-3 fw-bold text-success">{{
                                    number_format($punto->volumen_estimado_kg, 0) }} kg</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white text-center py-3">
                    <span class="text-muted small">Puntos aleatorios 15-30</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const camino = @json($ruta -> trayectorias -> map(fn($t) => [$t -> latitud, $t -> longitud]));
    const puntos = @json($ruta -> puntosRecoleccion);

    var map = L.map('map');

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Dibujar el camino trazado
    var polyline = L.polyline(camino, { color: '#6c757d', weight: 4, opacity: 0.6, dashArray: '5, 10' }).addTo(map);

    var marcadores = {};

    // Dibujar los puntos de recolección sembrados  
    puntos.forEach(p => {
        var marker = L.circleMarker([p.latitud, p.longitud], {
            radius: 7,
            fillColor: "#ffc107",
            color: "#212529",
            weight: 2,
            opacity: 1,
            fillOpacity: 0.9
        }).bindPopup(`<b>Punto #${p.posicion_orden}</b><br>Peso Estimado: ${p.volumen_estimado_kg} kg`)
          .addTo(map);
        
        marcadores[p.id_punto_recoleccion] = marker;
    });

    window.resaltarPunto = function(id) {
        // Resetear todos los estilos
        puntos.forEach(p => {
            marcadores[p.id_punto_recoleccion].setStyle({
                fillColor: "#ffc107",
                radius: 7,
                weight: 2
            });
        });

        // Aplicar estilo resaltado al seleccionado
        var m = marcadores[id];
        if (m) {
            m.setStyle({
                fillColor: "#0d6efd", // Azul corporativo
                radius: 10,
                weight: 3
            });
            m.openPopup();
            map.setView(m.getLatLng(), 16);
        }
    };

    // Ajustar vista inicial
    if (camino.length > 0) {
        map.fitBounds(polyline.getBounds(), { padding: [50, 50] });
    }
    });
</script>
@endsection