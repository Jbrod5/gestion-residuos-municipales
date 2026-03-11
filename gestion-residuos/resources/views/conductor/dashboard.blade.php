@extends('layouts.conductor')

@section('title', 'Dashboard del Conductor')

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white border-0 shadow">
                <div class="card-body p-4">
                    <h4 class="mb-0">
                        <i class="fas fa-truck me-2"></i>¡Bienvenido, {{ Auth::user()->nombre }}!
                    </h4>
                    <small>Gestiona tus rutas de recolección asignadas</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2 class="fw-bold">{{ $estadisticas['rutas_completadas'] }}</h2>
                    <p class="text-muted mb-0">Rutas Completadas</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="display-4 text-info mb-2">
                        <i class="fas fa-weight-hanging"></i>
                    </div>
                    <h2 class="fw-bold">{{ number_format($estadisticas['total_basura_recolectada'], 2) }} t</h2>
                    <p class="text-muted mb-0">Basura Recolectada</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted mb-3">Próxima Ruta</h6>
                    @if($estadisticas['proxima_ruta'])
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-route fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $estadisticas['proxima_ruta']->ruta->nombre }}</h6>
                                <small class="text-muted">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($estadisticas['proxima_ruta']->fecha)->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    @else
                        <p class="text-muted mb-0">No hay rutas programadas</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Ruta Actual (si existe) -->
    @if($estadisticas['ruta_actual'])
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-lg border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle me-3">
                                <i class="fas fa-play-circle fa-2x text-success"></i>
                            </div>
                            <div>
                                <h5 class="mb-1">Ruta en Proceso</h5>
                                <p class="text-muted mb-0">{{ $estadisticas['ruta_actual']->ruta->nombre }}</p>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('conductor.asignaciones.show', $estadisticas['ruta_actual']->id_asignacion_ruta) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-eye me-2"></i>Ver Detalles
                                </a>
                                <a href="{{ route('conductor.asignaciones.finalizar.form', $estadisticas['ruta_actual']->id_asignacion_ruta) }}" 
                                   class="btn btn-outline-success">
                                    <i class="fas fa-flag-checkered me-2"></i>Finalizar Ruta
                                </a>
                            </div>
                        </div>
                        
                        <!-- Mini mapa de la ruta actual -->
                        <div id="mapaRutaActual" style="height: 200px; border-radius: 10px;"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Asignaciones Activas -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">
                        <i class="fas fa-tasks me-2 text-success"></i>
                        Mis Rutas Activas
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($asignacionesActivas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Ruta</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Hora Inicio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($asignacionesActivas as $asignacion)
                                        <tr>
                                            <td>
                                                <strong>{{ $asignacion->ruta->nombre }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-weight-hanging me-1"></i>
                                                    {{ number_format($asignacion->basura_estimada_ton, 2) }} t estimadas
                                                </small>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($asignacion->fecha)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($asignacion->id_estado_asignacion_ruta == 1)
                                                    <span class="badge bg-warning text-dark">Programada</span>
                                                @elseif($asignacion->id_estado_asignacion_ruta == 2)
                                                    <span class="badge bg-success">En Proceso</span>
                                                @endif
                                            </td>
                                            <td>{{ $asignacion->hora_inicio ?? '—' }}</td>
                                            <td>
                                                <a href="{{ route('conductor.asignaciones.show', $asignacion->id_asignacion_ruta) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @if($asignacion->id_estado_asignacion_ruta == 1)
                                                    <a href="{{ route('conductor.asignaciones.iniciar', $asignacion->id_asignacion_ruta) }}" 
                                                       class="btn btn-sm btn-success"
                                                       onclick="return confirm('¿Iniciar esta ruta ahora?')">
                                                        <i class="fas fa-play"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle fa-4x text-muted mb-3"></i>
                            <h6 class="text-muted">No tienes rutas activas programadas</h6>
                            <small class="text-muted">Revisa tu historial para ver rutas completadas</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($estadisticas['ruta_actual'])
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar datos de la ruta actual via API
        fetch('{{ route("conductor.api.ruta-actual") }}')
            .then(response => response.json())
            .then(data => {
                if (data.error) return;
                
                // Inicializar mapa
                const mapa = L.map('mapaRutaActual').setView(
                    [data.ruta.latitud_inicio, data.ruta.longitud_inicio], 
                    14
                );
                
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap'
                }).addTo(mapa);
                
                // Dibujar trayectoria
                const puntosTrayectoria = data.trayectoria.map(p => [p.latitud, p.longitud]);
                L.polyline(puntosTrayectoria, { color: 'green', weight: 4 }).addTo(mapa);
                
                // Marcar puntos de recolección
                data.puntos_recoleccion.forEach(punto => {
                    L.marker([punto.latitud, punto.longitud], {
                        icon: L.divIcon({
                            className: 'bg-success bg-opacity-75 rounded-circle',
                            html: `<div style="width: 12px; height: 12px;"></div>`
                        })
                    }).addTo(mapa);
                });
                
                // Marcadores de inicio y fin
                L.marker([data.ruta.latitud_inicio, data.ruta.longitud_inicio])
                 .bindPopup('Inicio de Ruta')
                 .addTo(mapa);
                 
                L.marker([data.ruta.latitud_fin, data.ruta.longitud_fin])
                 .bindPopup('Fin de Ruta')
                 .addTo(mapa);
            });
    });
</script>
@endif
@endpush