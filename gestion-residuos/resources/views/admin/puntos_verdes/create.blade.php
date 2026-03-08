@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 80vh;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }

    .material-card {
        background: #f8f9fa;
        border-left: 4px solid #198754;
    }
</style>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
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
                                <input type="text" name="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre') }}" required>
                                <small class="text-muted">Ej: Centro de Acopio Norte</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Encargado Operativo</label>
                                <select name="id_encargado"
                                    class="form-select @error('id_encargado') is-invalid @enderror" required>
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
                            <input type="text" name="direccion"
                                class="form-control @error('direccion') is-invalid @enderror"
                                value="{{ old('direccion') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Capacidad Total Proyectada (m³)</label>
                                <input type="number" step="0.1" name="capacidad_total_m3" class="form-control"
                                    value="{{ old('capacidad_total_m3') }}" required>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-uppercase fw-bold text-success mb-3">Horario de Atención </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless align-middle">
                                <thead>
                                    <tr class="text-muted small uppercase">
                                        <th style="width: 150px;">Día</th>
                                        <th>Hora Inicio</th>
                                        <th>Hora Fin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($diasSemana as $dia)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input day-check" type="checkbox"
                                                    name="dias[{{ $dia->id_dia_semana }}]"
                                                    id="dia_{{ $dia->id_dia_semana }}" value="1"
                                                    data-target="slot_{{ $dia->id_dia_semana }}">
                                                <label class="form-check-label fw-bold"
                                                    for="dia_{{ $dia->id_dia_semana }}">{{ $dia->nombre }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="hora_inicio[{{ $dia->id_dia_semana }}]"
                                                class="form-control form-control-sm slot_{{ $dia->id_dia_semana }}"
                                                disabled>
                                        </td>
                                        <td>
                                            <input type="time" name="hora_fin[{{ $dia->id_dia_semana }}]"
                                                class="form-control form-control-sm slot_{{ $dia->id_dia_semana }}"
                                                disabled>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
                        <h6 class="text-uppercase fw-bold text-success mb-3">Configuración de Contenedores por Material
                        </h6>
                        <div class="row g-3">
                            @foreach($materiales as $material)
                            <div class="col-md-4">
                                <div class="card material-card h-100 p-2 shadow-sm">
                                    <div class="form-check mb-2">
                                        <label class="form-check-label fw-bold">{{ $material->nombre }}</label>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Cap. m³</span>
                                        <input type="number" step="0.1"
                                            name="contenedores[{{ $material->id_material }}]" class="form-control"
                                            value="0">
                                    </div>
                                    <small class="text-muted mt-1 small">Indique 0 si no acepta este material</small>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 d-grid">
                            <button type="submit" class="btn btn-success btn-lg fw-bold">GUARDAR NUEVO PUNTO
                                VERDE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([14.6349, -90.5069], 13); // Centrado en ciudad ejemplo

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        map.on('click', function (e) {
            if (marker) map.removeLayer(marker);
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('lat').value = e.latlng.lat.toFixed(6);
            document.getElementById('lng').value = e.latlng.lng.toFixed(6);
        });

        // Lógica de Horarios Normalizados successo total
        document.querySelectorAll('.day-check').forEach(check => {
            check.addEventListener('change', function () {
                const targetClass = this.getAttribute('data-target');
                const inputs = document.querySelectorAll('.' + targetClass);
                inputs.forEach(input => {
                    input.disabled = !this.checked;
                    if (!this.checked) input.value = '';
                });
            });
        });
    });
</script>
@endsection