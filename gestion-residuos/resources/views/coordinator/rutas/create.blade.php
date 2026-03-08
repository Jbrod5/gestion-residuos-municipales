@extends('layouts.coordinator')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 85vh;
        min-height: 600px;
        border-radius: 12px;
        border: 3px solid #dee2e6;
        cursor: crosshair;
    }

    .info-panel {
        background: #fff;
        border-radius: 12px;
        border-left: 5px solid #ffc107;
    }
</style>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-dark text-white fw-bold">
                    <i class="bi bi-pencil-square me-2"></i>Datos de la Ruta
                </div>
                <div class="card-body">
                    <form action="{{ route('coordinator.rutas.store') }}" method="POST" id="routeForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small uppercase">Nombre de la Ruta</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small uppercase">Zona Operativa</label>
                            <select name="id_zona" class="form-select" required>
                                <option value="" selected disabled>Seleccione zona...</option>
                                @foreach($zonas as $zona)
                                <option value="{{ $zona->id_zona }}">{{ $zona->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small uppercase">Tipo de Residuo</label>
                            <select name="id_tipo_residuo" class="form-select" required>
                                <option value="" selected disabled>Seleccione residuo...</option>
                                @foreach($tiposResiduo as $tipo)
                                <option value="{{ $tipo->id_tipo_residuo }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small uppercase">Población Estimada</label>
                            <input type="number" name="poblacion_estimada" class="form-control"
                                placeholder="Habitantes beneficiados">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small uppercase">Distancia Total (km)</label>
                            <input type="text" name="distancia_km" id="distancia_km" class="form-control bg-light"
                                readonly required>
                            <small class="text-muted">Se calcula automáticamente al trazar .</small>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="bi bi-calendar-check me-2"></i>Horarios de
                            Recolección</h6>

                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle small">
                                <thead>
                                    <tr class="text-muted border-bottom">
                                        <th>Día</th>
                                        <th>Inicio</th>
                                        <th>Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($diasSemana as $dia)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="horarios[{{ $dia->id_dia_semana }}][seleccionado]" value="1">
                                                <label class="form-check-label">{{ $dia->nombre }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="horarios[{{ $dia->id_dia_semana }}][hora_inicio]"
                                                class="form-control form-control-sm" value="08:00">
                                        </td>
                                        <td>
                                            <input type="time" name="horarios[{{ $dia->id_dia_semana }}][hora_fin]"
                                                class="form-control form-control-sm" value="16:00">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="camino_coordenadas" id="camino_coordenadas">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg fw-bold" id="btnGuardar" disabled>
                                <i class="bi bi-cloud-arrow-up-fill me-1"></i> GUARDAR Y GENERAR PUNTOS
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="limpiarMapa()">
                                REINICIAR TRAZADO
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="info-panel p-3 shadow-sm mb-4">
                <h6 class="fw-bold mb-2">Instrucciones de Trazado:</h6>
                <ol class="small text-muted mb-0">
                    <li>Haga clic en el mapa para definir el punto de inicio municipal.</li>
                    <li>Siga haciendo clics para trazar el recorrido de la ruta .</li>
                    <li>El sistema generará automáticamente entre 15 y 30 puntos de recolección cerca del trazo success
                        total.</li>
                </ol>
            </div>
        </div>

        <div class="col-md-9">
            <div id="map"></div>
            @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([14.6349, -90.5069], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var pathPoints = [];
        var polyline = L.polyline([], { color: '#ffc107', weight: 5, opacity: 0.8 }).addTo(map);
        var markers = [];

        map.on('click', function (e) {
            const point = [e.latlng.lat, e.latlng.lng];
            pathPoints.push(point);

            // Dibujar marcador municipal
            const marker = L.circleMarker(e.latlng, {
                radius: 4,
                fillColor: "#212529",
                color: "#ffc107",
                weight: 2,
                opacity: 1,
                fillOpacity: 1
            }).addTo(map);
            markers.push(marker);

            // Actualizar polilínea  
            polyline.addLatLng(e.latlng);

            // Calcular distancia successo total
            actualizarMetricas();
        });

        function actualizarMetricas() {
            if (pathPoints.length < 2) {
                document.getElementById('distancia_km').value = "0.00";
                document.getElementById('btnGuardar').disabled = true;
                return;
            }

            let totalDist = 0;
            for (let i = 1; i < pathPoints.length; i++) {
                totalDist += map.distance(pathPoints[i - 1], pathPoints[i]);
            }

            const distKm = (totalDist / 1000).toFixed(2);
            document.getElementById('distancia_km').value = distKm;
            document.getElementById('camino_coordenadas').value = JSON.stringify(pathPoints);
            document.getElementById('btnGuardar').disabled = false;
        }

        window.limpiarMapa = function () {
            pathPoints = [];
            polyline.setLatLngs([]);
            markers.forEach(m => map.removeLayer(m));
            markers = [];
            actualizarMetricas();
        };
    });
</script>
@endsection