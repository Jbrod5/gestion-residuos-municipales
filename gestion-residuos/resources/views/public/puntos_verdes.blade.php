@extends('layouts.citizen') 

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2 class="mb-1 fw-bold">puntos verdes municipales</h2>
        <p class="text-muted mb-0">ubicaciones de reciclaje disponibles en el municipio</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-3">
        <div id="map" style="width: 100%; height: 480px; border-radius: 8px; border: 1px solid #dee2e6;"></div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title fw-bold mb-3">detalle del punto seleccionado</h5>
                <p class="text-muted small mb-3">
                    haz clic en un marcador del mapa para ver la información del punto verde
                </p>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody id="detalle-punto-verde">
                            <tr>
                                <td class="text-muted">nombre</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">dirección</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">horario</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td class="text-muted">materiales</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const puntos = @json($puntosVerdes);

        // centro inicial: si hay puntos usar el primero, si no usar coordenadas por defecto (guatemala ciudad)
        let centerLat = 14.6349;
        let centerLng = -90.5069;
        if (puntos.length > 0) {
            centerLat = puntos[0].latitud;
            centerLng = puntos[0].longitud;
        }

        const map = L.map('map').setView([centerLat, centerLng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const detalleBody = document.getElementById('detalle-punto-verde');

        function renderDetalle(punto) {
            const materiales = (punto.contenedores || [])
                .map(c => c.material ? c.material.nombre : null)
                .filter(Boolean)
                .join(', ');

            detalleBody.innerHTML = `
                <tr>
                    <td class="text-muted">nombre</td>
                    <td>${punto.nombre || '-'}</td>
                </tr>
                <tr>
                    <td class="text-muted">dirección</td>
                    <td>${punto.direccion || '-'}</td>
                </tr>
                <tr>
                    <td class="text-muted">horario</td>
                    <td>${punto.horario || '-'}</td>
                </tr>
                <tr>
                    <td class="text-muted">materiales</td>
                    <td>${materiales || '-'}</td>
                </tr>
            `;
        }

        puntos.forEach(function (punto) {
            if (!punto.latitud || !punto.longitud) return;

            const marker = L.marker([punto.latitud, punto.longitud]).addTo(map);
            marker.bindPopup(punto.nombre || 'punto verde');

            marker.on('click', function () {
                renderDetalle(punto);
            });
        });

        // si solo hay un punto, mostrar detalle inicial
        if (puntos.length === 1) {
            renderDetalle(puntos[0]);
        }
    });
</script>
@endsection

