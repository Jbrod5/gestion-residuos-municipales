@extends('layouts.citizen')

@section('content')
<!-- Leaflet CSS municipal -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        width: 100%;
        border-radius: 12px;
        border: 2px solid #198754;
        margin-bottom: 20px;
        z-index: 1;
    }
    .gps-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 1000;
        background: white;
        padding: 5px 10px;
        border: 2px solid rgba(0,0,0,0.2);
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }
    .gps-btn:hover { background: #f4f4f4; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white py-3">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-megaphone-fill me-2"></i>Reportar Basurero Clandestino</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('ciudadano.denuncias.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">1. Ubicación del Problema municipal</label>
                            <p class="text-muted small mb-2">Haz clic en el mapa para marcar el lugar exacto o usa el botón de geolocalización municipal.</p>
                            <div class="position-relative">
                                <div id="map"></div>
                                <button type="button" class="gps-btn" id="btn-gps">
                                    <i class="bi bi-crosshair2 me-1"></i> Mi Ubicación
                                </button>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="latitud" class="form-label small fw-bold uppercase">Latitud</label>
                                    <input type="number" step="any" name="latitud" id="latitud" class="form-control @error('latitud') is-invalid @enderror" value="{{ old('latitud') }}" required readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="longitud" class="form-label small fw-bold uppercase">Longitud</label>
                                    <input type="number" step="any" name="longitud" id="longitud" class="form-control @error('longitud') is-invalid @enderror" value="{{ old('longitud') }}" required readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="id_tamano_denuncia" class="form-label fw-bold">2. Tamaño Estimado municipal</label>
                            <select name="id_tamano_denuncia" id="id_tamano_denuncia" class="form-select @error('id_tamano_denuncia') is-invalid @enderror" required>
                                <option value="" selected disabled>Selecciona una magnitud</option>
                                @foreach($tamanos as $tamano)
                                    <option value="{{ $tamano->id_tamano_denuncia }}" {{ old('id_tamano_denuncia') == $tamano->id_tamano_denuncia ? 'selected' : '' }}>
                                        {{ $tamano->nombre }} - {{ $tamano->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold">3. Detalles Adicionales municipal</label>
                            <textarea name="descripcion" id="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror" required placeholder="Describe referencias del lugar o el tipo de desechos municipal">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="form-label fw-bold">4. Evidencia Fotográfica municipal</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            <div class="form-text mt-2"><i class="bi bi-info-circle me-1"></i>Las fotos ayudan a la cuadrilla a priorizar la limpieza municipal.</div>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{ route('ciudadano.hub') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                            <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm">ENVIAR REPORTE MUNICIPAL</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet JS municipal -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Coordenadas por defecto (Centro de la ciudad municipal)
    const defaultLat = 14.6349;
    const defaultLng = -90.5069;
    
    const map = L.map('map').setView([defaultLat, defaultLng], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    let marker;

    function updateMarker(lat, lng) {
        if (marker) map.removeLayer(marker);
        marker = L.marker([lat, lng], {draggable: true}).addTo(map);
        
        document.getElementById('latitud').value = lat.toFixed(6);
        document.getElementById('longitud').value = lng.toFixed(6);

        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            document.getElementById('latitud').value = position.lat.toFixed(6);
            document.getElementById('longitud').value = position.lng.toFixed(6);
        });
    }

    // Al hacer clic en el mapa municipal
    map.on('click', function(e) {
        updateMarker(e.latlng.lat, e.latlng.lng);
    });

    // Botón GPS municipal
    document.getElementById('btn-gps').addEventListener('click', function() {
        if (navigator.geolocation) {
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Localizando...';
            navigator.geolocation.getCurrentPosition(position => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 17);
                updateMarker(lat, lng);
                this.innerHTML = '<i class="bi bi-crosshair2 me-1"></i> Mi Ubicación';
            }, error => {
                alert('No se pudo obtener la ubicación municipal: ' + error.message);
                this.innerHTML = '<i class="bi bi-crosshair2 me-1"></i> Mi Ubicación';
            });
        } else {
            alert('Tu navegador no soporta geolocalización municipal.');
        }
    });

    // Si ya hay coordenadas por validación fallida municipal
    const oldLat = "{{ old('latitud') }}";
    const oldLng = "{{ old('longitud') }}";
    if (oldLat && oldLng) {
        updateMarker(parseFloat(oldLat), parseFloat(oldLng));
        map.setView([oldLat, oldLng], 15);
    }
});
</script>
@endsection
