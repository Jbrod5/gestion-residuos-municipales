@extends('layouts.auditor')

@section('title', 'Panel de Auditoría')

@push('styles')
<style>
    .export-btn-group {
        transition: all 0.3s;
    }
    .export-btn-group:hover {
        transform: translateY(-2px);
    }
    .dropdown-export .dropdown-item i {
        width: 20px;
        text-align: center;
    }
    .card-header-export {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Filtros de periodo para fiscalización</span>
                <form class="d-flex gap-2" method="GET">
                    <input type="date" name="desde" class="form-control form-control-sm" value="{{ $fechaInicio }}">
                    <input type="date" name="hasta" class="form-control form-control-sm" value="{{ $fechaFin }}">
                    <button class="btn btn-sm btn-outline-info" type="submit">
                        <i class="bi bi-filter-circle me-1"></i>Aplicar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Botón de exportación general (opcional) -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="d-flex justify-content-end gap-2">
            <div class="dropdown">
                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-file-csv me-2"></i>Exportar Todo
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('auditor.exportar.recoleccion', request()->all()) }}">
                            <i class="fas fa-truck me-2 text-primary"></i>Recolecciones
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auditor.exportar.denuncias', request()->all()) }}">
                            <i class="fas fa-exclamation-triangle me-2 text-warning"></i>Denuncias
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auditor.exportar.reciclaje', request()->all()) }}">
                            <i class="fas fa-recycle me-2 text-success"></i>Reciclaje
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('auditor.exportar.completo', request()->all()) }}">
                            <i class="fas fa-file-archive me-2 text-danger"></i>Reporte Completo
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Toneladas recolectadas por zona</span>
                <a href="{{ route('auditor.exportar.recoleccion', array_merge(request()->all(), ['tipo' => 'zonas'])) }}" 
                   class="btn btn-sm btn-outline-secondary export-btn-group" 
                   title="Exportar datos de zonas">
                    <i class="fas fa-file-csv me-1"></i>Exportar
                </a>
            </div>
            <div class="card-body">
                <canvas id="chart-basura-zona"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Material reciclado por tipo</span>
                <a href="{{ route('auditor.exportar.reciclaje', array_merge(request()->all(), ['tipo' => 'materiales'])) }}" 
                   class="btn btn-sm btn-outline-secondary export-btn-group"
                   title="Exportar datos de materiales">
                    <i class="fas fa-file-csv me-1"></i>Exportar
                </a>
            </div>
            <div class="card-body">
                <canvas id="chart-material"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Denuncias recibidas vs atendidas (último mes)</span>
                <a href="{{ route('auditor.exportar.denuncias', array_merge(request()->all(), ['tipo' => 'estadisticas'])) }}" 
                   class="btn btn-sm btn-outline-secondary export-btn-group"
                   title="Exportar estadísticas de denuncias">
                    <i class="fas fa-file-csv me-1"></i>Exportar
                </a>
            </div>
            <div class="card-body">
                <canvas id="chart-denuncias"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Trazabilidad de rutas y recolección</span>
                <div class="btn-group" role="group">
                    <a href="{{ route('auditor.exportar.recoleccion', request()->all()) }}" 
                       class="btn btn-sm btn-outline-success" 
                       title="Exportar todas las recolecciones">
                        <i class="fas fa-file-csv me-1"></i>Exportar CSV
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Ruta</th>
                            <th>Zona</th>
                            <th>Camión</th>
                            <th>Estado</th>
                            <th>Basura estimada (t)</th>
                            <th>Basura recolectada (t)</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asignaciones as $asignacion)
                            <tr>
                                <td>{{ $asignacion->fecha }}</td>
                                <td>{{ $asignacion->ruta?->nombre }}</td>
                                <td>{{ $asignacion->ruta?->zona?->nombre }}</td>
                                <td>{{ $asignacion->camion?->placa }}</td>
                                <td>
                                    <span class="badge bg-{{ $asignacion->estado?->color ?? 'secondary' }}">
                                        {{ $asignacion->estado?->nombre }}
                                    </span>
                                </td>
                                <td>{{ number_format($asignacion->basura_estimada_ton, 2) }}</td>
                                <td>{{ $asignacion->basura_recolectada_ton ? number_format($asignacion->basura_recolectada_ton, 2) : '-' }}</td>
                                <td>
                                    <a href="{{ route('auditor.show', ['tipo' => 'asignacion', 'id' => $asignacion->id_asignacion_ruta]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No hay asignaciones en el periodo seleccionado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($asignaciones, 'links'))
            <div class="card-footer">
                {{ $asignaciones->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Control de puntos verdes y entregas</span>
                <a href="{{ route('auditor.exportar.reciclaje', request()->all()) }}" 
                   class="btn btn-sm btn-outline-success">
                    <i class="fas fa-file-csv me-1"></i>Exportar CSV
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Punto verde</th>
                            <th>Material</th>
                            <th>Cantidad (kg)</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($entregas as $entrega)
                            <tr>
                                <td>{{ $entrega->puntoVerde?->nombre }}</td>
                                <td>{{ $entrega->material?->nombre }}</td>
                                <td>{{ number_format($entrega->cantidad_kg, 2) }}</td>
                                <td>{{ $entrega->fecha instanceof \Carbon\Carbon ? $entrega->fecha->format('d/m/Y') : $entrega->fecha }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No hay entregas registradas en el periodo</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer small text-muted">
                Volumen total por punto verde
            </div>
            <ul class="list-group list-group-flush">
                @foreach ($puntosVerdes as $punto)
                    @php
                        $totalM3 = $punto->contenedores->sum('nivel_actual_m3');
                    @endphp
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-map-marker-alt text-success me-2"></i>
                            {{ $punto->nombre }}
                        </span>
                        <span class="badge bg-info">{{ number_format($totalM3, 2) }} m³</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Seguimiento de denuncias ciudadanas</span>
                <a href="{{ route('auditor.exportar.denuncias', request()->all()) }}" 
                   class="btn btn-sm btn-outline-success">
                    <i class="fas fa-file-csv me-1"></i>Exportar CSV
                </a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Ciudadano</th>
                            <th>Estado</th>
                            <th>Tamaño</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($denuncias as $denuncia)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($denuncia->fecha)->format('d/m/Y') }}</td>
                                <td>{{ $denuncia->usuario?->nombre }}</td>
                                <td>
                                    <span class="badge bg-{{ $denuncia->estado?->color ?? 'secondary' }}">
                                        {{ $denuncia->estado?->nombre }}
                                    </span>
                                </td>
                                <td>{{ $denuncia->tamano?->nombre }}</td>
                                <td>
                                    <a href="{{ route('auditor.show', ['tipo' => 'denuncia', 'id' => $denuncia->id_denuncia]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-image me-1"></i>Ver
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay denuncias registradas en el periodo</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Scripts de Chart.js (se mantienen igual) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('admin.reportes.api') }}?desde={{ $fechaInicio }}&hasta={{ $fechaFin }}')
        .then(r => r.json())
        .then(data => {
            // Gráfico de basura por zona
            const ctx1 = document.getElementById('chart-basura-zona').getContext('2d')
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: data.basuraPorZona.map(z => z.zona),
                    datasets: [{
                        label: 'Toneladas',
                        data: data.basuraPorZona.map(z => z.toneladas),
                        backgroundColor: 'rgba(23, 162, 184, 0.7)',
                        borderColor: 'rgba(23, 162, 184, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    }
                }
            })

            // Gráfico de material reciclado
            const ctx2 = document.getElementById('chart-material').getContext('2d')
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: data.materialReciclado.map(m => m.material),
                    datasets: [{
                        data: data.materialReciclado.map(m => m.kg),
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            })

            // Gráfico de denuncias
            const ctx3 = document.getElementById('chart-denuncias').getContext('2d')
            new Chart(ctx3, {
                type: 'line',
                data: {
                    labels: data.denunciasSerie.fechas,
                    datasets: [
                        {
                            label: 'Recibidas',
                            data: data.denunciasSerie.recibidas,
                            borderColor: '#007bff',
                            backgroundColor: 'rgba(0, 123, 255, 0.1)',
                            fill: false,
                            tension: 0.4
                        },
                        {
                            label: 'Atendidas',
                            data: data.denunciasSerie.atendidas,
                            borderColor: '#28a745',
                            backgroundColor: 'rgba(40, 167, 69, 0.1)',
                            fill: false,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            })
        })
        .catch(error => {
            console.error('Error cargando datos de gráficos:', error);
        });
});
</script>
@endsection