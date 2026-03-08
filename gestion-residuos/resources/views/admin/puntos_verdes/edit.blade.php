@extends('layouts.admin')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        border-radius: 8px;
        border: 2px solid #dee2e6;
    }

    .material-card {
        background: #f8f9fa;
        border-left: 4px solid #ffc107;
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Editar Infraestructura: {{ $punto->nombre }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.puntos-verdes.update', $punto->id_punto_verde) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre del Punto Verde</label>
                                <input type="text" name="nombre"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    value="{{ old('nombre', $punto->nombre) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Encargado Operativo</label>
                                <select name="id_encargado"
                                    class="form-select @error('id_encargado') is-invalid @enderror" required>
                                    @foreach($operadores as $operador)
                                    <option value="{{ $operador->id_usuario }}" {{ $punto->id_encargado ==
                                        $operador->id_usuario ? 'selected' : '' }}>
                                        {{ $operador->nombre }}
                                    </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Solo personal con rol Operador de Punto Verde</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Dirección Completa</label>
                            <input type="text" name="direccion"
                                class="form-control @error('direccion') is-invalid @enderror"
                                value="{{ old('direccion', $punto->direccion) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Capacidad Total Proyectada (m³)</label>
                                <input type="number" step="0.1" name="capacidad_total_m3" class="form-control"
                                    value="{{ old('capacidad_total_m3', $punto->capacidad_total_m3) }}" required>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-uppercase fw-bold text-success mb-3">Horario de Atención</h6>
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
                                    @php
                                    $activo = isset($horariosActivos[$dia->id_dia_semana]);
                                    $hInicio = $activo ? $horariosActivos[$dia->id_dia_semana]->hora_inicio : '';
                                    $hFin = $activo ? $horariosActivos[$dia->id_dia_semana]->hora_fin : '';
                                    @endphp
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input day-check" type="checkbox"
                                                    name="dias[{{ $dia->id_dia_semana }}]"
                                                    id="dia_{{ $dia->id_dia_semana }}" value="1"
                                                    data-target="slot_{{ $dia->id_dia_semana }}" {{ $activo ? 'checked'
                                                    : '' }}>
                                                <label class="form-check-label fw-bold"
                                                    for="dia_{{ $dia->id_dia_semana }}">{{ $dia->nombre }}</label>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="time" name="hora_inicio[{{ $dia->id_dia_semana }}]"
                                                class="form-control form-control-sm slot_{{ $dia->id_dia_semana }}"
                                                value="{{ \Carbon\Carbon::parse($hInicio)->format('H:i') }}" {{ !$activo
                                                ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <input type="time" name="hora_fin[{{ $dia->id_dia_semana }}]"
                                                class="form-control form-control-sm slot_{{ $dia->id_dia_semana }}"
                                                value="{{ \Carbon\Carbon::parse($hFin)->format('H:i') }}" {{ !$activo
                                                ? 'disabled' : '' }}>
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
                                <input type="text" name="latitud" id="lat" class="form-control"
                                    value="{{ $punto->latitud }}" readonly required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Longitud</label>
                                <input type="text" name="longitud" id="lng" class="form-control"
                                    value="{{ $punto->longitud }}" readonly required>
                            </div>
                        </div>

                        <hr>
                        <h6 class="text-uppercase fw-bold text-success mb-3">Configuración de Contenedores por Material
                        </h6>
                        <div class="row g-3">
                            @foreach($materiales as $material)
                            @php
                            $capacidad = isset($contenedoresActivos[$material->id_material]) ?
                            $contenedoresActivos[$material->id_material]->capacidad_maxima_m3 : 0;
                            @endphp
                            <div class="col-md-4">
                                <div class="card material-card h-100 p-2 shadow-sm">
                                    <div class="form-check mb-2">
                                        <label class="form-check-label fw-bold">{{ $material->nombre }}</label>
                                    </div>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">Cap. m³</span>
                                        <input type="number" step="0.1"
                                            name="contenedores[{{ $material->id_material }}]" class="form-control"
                                            value="{{ $capacidad }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-4 d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.puntos-verdes.index') }}"
                                class="btn btn-outline-secondary btn-lg">CANCELAR</a>
                            <button type="submit" class="btn btn-warning btn-lg fw-bold">ACTUALIZAR PUNTO VERDE</button>
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
        const lat = {{ $punto-> latitud
    }};
    const lng = {{ $punto-> longitud }};

    var map = L.map('map').setView([lat, lng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    var marker = L.marker([lat, lng]).addTo(map);

    map.on('click', function (e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('lat').value = e.latlng.lat.toFixed(6);
        document.getElementById('lng').value = e.latlng.lng.toFixed(6);
    });

    // Lógica de Horarios Normalizados
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