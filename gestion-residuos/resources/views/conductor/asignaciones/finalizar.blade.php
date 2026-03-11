@extends('layouts.conductor')

@section('title', 'Finalizar Ruta')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        border-radius: 12px;
        border: 2px solid #dee2e6;
    }
    .card-estadistica {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header bg-success py-3">
                    <h5 class="mb-0 text-white fw-bold">
                        <i class="fas fa-flag-checkered me-2"></i>
                        Finalizar Ruta: {{ $asignacion->ruta->nombre }}
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <!-- Resumen de la ruta -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Basura Estimada</small>
                                    <h4 class="fw-bold text-success">{{ number_format($asignacion->basura_estimada_ton, 2) }} t</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Capacidad Camión</small>
                                    <h4 class="fw-bold text-info">{{ number_format($asignacion->camion->capacidad_toneladas, 2) }} t</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Puntos Recolectados</small>
                                    <h4 class="fw-bold">{{ $asignacion->ruta->puntosRecoleccion->count() }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light border-0">
                                <div class="card-body text-center">
                                    <small class="text-muted">Hora Inicio</small>
                                    <h4 class="fw-bold">{{ $asignacion->hora_inicio ?? '—' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa de la ruta (vista previa) -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Recorrido Realizado</label>
                        <div id="map"></div>
                    </div>

                    <!-- Formulario para finalizar -->
                    <form action="{{ route('conductor.asignaciones.finalizar', $asignacion->id_asignacion_ruta) }}" 
                          method="POST" 
                          id="formFinalizar"
                          onsubmit="return validarBasura()">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-weight-hanging text-success me-2"></i>
                                        Basura Recolectada (toneladas)
                                    </label>
                                    <input type="number" 
                                           name="basura_recolectada_ton" 
                                           id="basura_recolectada_ton"
                                           class="form-control form-control-lg @error('basura_recolectada_ton') is-invalid @enderror"
                                           step="0.01"
                                           min="0"
                                           max="{{ $asignacion->camion->capacidad_toneladas }}"
                                           value="{{ old('basura_recolectada_ton') }}"
                                           required>
                                    <small class="text-muted">
                                        Capacidad máxima: {{ $asignacion->camion->capacidad_toneladas }} toneladas
                                    </small>
                                    @error('basura_recolectada_ton')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        Incidencias (opcional)
                                    </label>
                                    <textarea name="notas_incidencias" 
                                              class="form-control @error('notas_incidencias') is-invalid @enderror"
                                              rows="3"
                                              placeholder="Ej: Tráfico intenso, contenedor dañado, etc.">{{ old('notas_incidencias') }}</textarea>
                                    @error('notas_incidencias')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Sugerencias de basura basadas en puntos -->
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Sugerencia:</strong> La suma estimada de los puntos es 
                            <strong>{{ number_format($asignacion->ruta->puntosRecoleccion->sum('volumen_estimado_kg') / 1000, 2) }} t</strong>
                        </div>

                        <!-- Checkbox de confirmación -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="confirmar" required>
                                <label class="form-check-label" for="confirmar">
                                    Confirmo que he completado el recorrido de esta ruta y los datos ingresados son correctos
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('conductor.asignaciones.show', $asignacion->id_asignacion_ruta) }}" 
                               class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check-circle me-2"></i>
                                Confirmar Finalización
                            </button>
                        </div>
                    </form>
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
        var map = L.map('map').setView([14.6349, -90.5069], 12);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        // Dibujar trayectoria
        if (trayectorias.length > 0) {
            var polyline = L.polyline(trayectorias, {
                color: '#28a745',
                weight: 4
            }).addTo(map);
            
            // Dibujar puntos de recolección
            puntos.forEach(p => {
                L.circleMarker([p.latitud, p.longitud], {
                    radius: 6,
                    fillColor: "#ffc107",
                    color: "#212529",
                    weight: 1,
                    fillOpacity: 0.9
                }).addTo(map);
            });
            
            map.fitBounds(polyline.getBounds(), { padding: [50, 50] });
        }
    });

    // Validación personalizada
    function validarBasura() {
        const basura = parseFloat(document.getElementById('basura_recolectada_ton').value);
        const capacidad = {{ $asignacion->camion->capacidad_toneladas }};
        const estimado = {{ $asignacion->basura_estimada_ton }};
        
        if (basura > capacidad) {
            alert('La basura recolectada no puede exceder la capacidad del camión');
            return false;
        }
        
        if (basura < 0) {
            alert('La basura recolectada debe ser un valor positivo');
            return false;
        }
        
        // Advertencia si es muy diferente a lo estimado
        if (Math.abs(basura - estimado) > estimado * 0.3) {
            return confirm('La cantidad ingresada es muy diferente a la estimada (' + estimado + ' t). ¿Estás seguro?');
        }
        
        return true;
    }
</script>
@endpush