@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { height: 400px; border-radius: 8px; border: 2px solid #dee2e6; }
    .material-card { background: #f8f9fa; border-left: 4px solid #198754; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Registrar Punto Verde de Reciclaje</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.puntos-verdes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Punto Verde</label>
                                <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                                <small class="text-muted">Ej: Centro de Acopio Norte</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Encargado Operativo</label>
                                <select name="id_encargado" class="form-select @error('id_encargado') is-invalid @enderror" required>
                                    <option value="" selected disabled>Seleccione un operador</option>
                                    @foreach($operadores as $operador)
                                        <option value="{{ $operador->id_usuario }}">{{ $operador->nombre }}</option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Solo personal con rol Operador de Punto Verde</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dirección Completa</label>
                            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Horario de Atención</label>
                                <input type="text" name="horario" class="form-control" value="{{ old('horario') }}" placeholder="Lun-Vie 8:00 - 17:00">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Capacidad Total Proyectada (m³)</label>
                                <input type="number" step="0.1" name="capacidad_total_m3" class="form-control" value="{{ old('capacidad_total_m3') }}" required>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-uppercase fw-bold text-success mb-3">Ubicación Geográfica (Leaflet)</h6>
                        <div id="map" class="mb-3"></div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Latitud</label>
                                <input type="text" name="latitud" id="lat" class="form-control" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitud</label>
                                <input type="text" name="longitud" id="lng" class="form-control" readonly required>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-uppercase fw-bold text-success mb-3">Configuración de Contenedores por Material</h6>
                        <div class="row g-3">
                            @foreach($materiales as $material)
                                <div class="col-md-4">
                                    <div class="card material-card h-100 p-2 shadow-sm">
                                        <div class="form-check mb-2">
                                            <label class="form-check-label fw-bold">{{ $material->nombre }}</label>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">Cap. m³</span>
                                            <input type="number" step="0.1" name="contenedores[{{ $material->id_material }}]" class="form-control" value="0">
                                        </div>
                                        <small class="text-muted mt-1 small">Indique 0 si no acepta este material</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-4 d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">GUARDAR INFRAESTRUCTURA MUNICIPAL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([14.6349, -90.5069], 13); // Centrado en ciudad ejemplo

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        map.on('click', function(e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('lat').value = e.latlng.lat.toFixed(6);
            document.getElementById('lng').value = e.latlng.lng.toFixed(6);
        });
    });
</script>
@endsection
