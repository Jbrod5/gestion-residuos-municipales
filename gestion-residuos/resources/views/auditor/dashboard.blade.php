@extends('layouts.auditor')

@section('title', 'Panel de Auditoría')

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

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Toneladas recolectadas por zona</span>
                <button class="btn btn-sm btn-outline-secondary" type="button">Exportar</button>
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
                <button class="btn btn-sm btn-outline-secondary" type="button">Exportar</button>
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
                <button class="btn btn-sm btn-outline-secondary" type="button">Exportar</button>
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
                <button class="btn btn-sm btn-outline-secondary" type="button">Exportar</button>
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
                                <td>{{ $asignacion->basura_estimada_ton }}</td>
                                <td>{{ $asignacion->basura_recolectada_ton ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('auditor.show', ['tipo' => 'asignacion', 'id' => $asignacion->id_asignacion_ruta]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver detalle
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
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Control de puntos verdes y entregas</span>
                <button class="btn btn-sm btn-outline-secondary" type="button">Exportar</button>
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
                                <td>{{ $entrega->cantidad_kg }}</td>
                                <td>{{ $entrega->fecha }}</td>
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
                        <span>{{ $punto->nombre }}</span>
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
                <button class="btn btn-sm btn-outline-secondary" type="button">Exportar</button>
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
                                <td>{{ $denuncia->fecha }}</td>
                                <td>{{ $denuncia->usuario?->nombre }}</td>
                                <td>{{ $denuncia->estado?->nombre }}</td>
                                <td>{{ $denuncia->tamano?->nombre }}</td>
                                <td>
                                    <a href="{{ route('auditor.show', ['tipo' => 'denuncia', 'id' => $denuncia->id_denuncia]) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver evidencia
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    fetch('{{ route('admin.reportes.api') }}')
        .then(r => r.json())
        .then(data => {
            const ctx1 = document.getElementById('chart-basura-zona').getContext('2d')
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: data.basuraPorZona.map(z => z.zona),
                    datasets: [{
                        label: 'Toneladas',
                        data: data.basuraPorZona.map(z => z.toneladas),
                        backgroundColor: 'rgba(23, 162, 184, 0.7)'
                    }]
                }
            })

            const ctx2 = document.getElementById('chart-material').getContext('2d')
            new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: data.materialReciclado.map(m => m.material),
                    datasets: [{
                        data: data.materialReciclado.map(m => m.kg),
                        backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8']
                    }]
                }
            })

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
                            fill: false
                        },
                        {
                            label: 'Atendidas',
                            data: data.denunciasSerie.atendidas,
                            borderColor: '#28a745',
                            fill: false
                        }
                    ]
                }
            })
        })
})
</script>
@endsection

