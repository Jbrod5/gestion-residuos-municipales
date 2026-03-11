@extends('layouts.publico')

@section('title', 'Puntos Verdes - XelaLimpia')

@push('styles')
<style>
    #map { width: 100%; height: 500px; border-radius: 8px; }
    .punto-card { cursor: pointer; transition: all 0.2s; }
    .punto-card:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-success">
                <i class="bi bi-recycle me-2"></i>
                Puntos Verdes Municipales
            </h2>
            <p class="text-muted">Centros de acopio para materiales reciclables en Quetzaltenango</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-geo-alt me-2"></i>Ubicaciones
                </div>
                <div class="card-body p-1">
                    <div id="map"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-info-circle me-2"></i>Detalle del punto
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        <i class="bi bi-hand-index-thumb me-1"></i>
                        Haz clic en un marcador del mapa para ver la información
                    </p>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <tbody id="detalle-punto-verde">
                                <tr>
                                    <td class="text-muted">Nombre</td>
                                    <td class="fw-bold">-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Dirección</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Horario</td>
                                    <td>-</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Materiales</td>
                                    <td>-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Lista rápida de puntos -->
            <div class="card shadow mt-3">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-list me-2"></i>Lista de puntos
                </div>
                <div class="list-group list-group-flush" id="lista-puntos" style="max-height: 200px; overflow-y: auto;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('publico.api.puntos') }}')
        .then(r => r.json())
        .then(puntos => {
            // centro inicial
            let centerLat = 14.84;
            let centerLng = -91.52;
            if (puntos.length > 0) {
                centerLat = puntos[0].latitud;
                centerLng = puntos[0].longitud;
            }

            const map = L.map('map').setView([centerLat, centerLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            const detalleBody = document.getElementById('detalle-punto-verde');
            const listaPuntos = document.getElementById('lista-puntos');

            function renderDetalle(punto) {
                const materiales = (punto.contenedores || [])
                    .map(c => c.material ? c.material.nombre : null)
                    .filter(Boolean)
                    .join(', ');

                detalleBody.innerHTML = `
                    <tr>
                        <td class="text-muted">Nombre</td>
                        <td class="fw-bold text-success">${punto.nombre || '-'}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Dirección</td>
                        <td>${punto.direccion || '-'}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Horario</td>
                        <td>${punto.horario || '-'}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Materiales</td>
                        <td>${materiales || '-'}</td>
                    </tr>
                `;
            }

            puntos.forEach(function (punto) {
                if (!punto.latitud || !punto.longitud) return;

                // Marcador en mapa
                const marker = L.marker([punto.latitud, punto.longitud]).addTo(map);
                marker.bindPopup(`
                    <strong class="text-success">${punto.nombre}</strong><br>
                    <small>${punto.direccion}</small>
                `);

                marker.on('click', function () {
                    renderDetalle(punto);
                });

                // Elemento en lista lateral
                const item = document.createElement('a');
                item.className = 'list-group-item list-group-item-action punto-card';
                item.href = '#';
                item.innerHTML = `
                    <i class="bi bi-geo-alt-fill text-success me-2"></i>
                    <strong>${punto.nombre}</strong>
                    <small class="d-block text-muted">${punto.direccion.substring(0, 40)}...</small>
                `;
                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    map.setView([punto.latitud, punto.longitud], 16);
                    marker.openPopup();
                    renderDetalle(punto);
                });
                listaPuntos.appendChild(item);
            });

            // si solo hay un punto, mostrar detalle inicial
            if (puntos.length === 1) {
                renderDetalle(puntos[0]);
            }
        });
});
</script>
@endpush