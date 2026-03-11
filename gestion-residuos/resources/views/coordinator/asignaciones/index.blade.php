@extends('layouts.coordinator')

@section('title', 'Asignación de Rutas')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h2 class="mb-0 text-success fw-bold">Planificación de Rutas</h2>
            <p class="text-muted mb-0">Asignación de recursos físicos para recolección municipal</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('coordinator.asignaciones.create') }}" class="btn btn-success px-4">
                <i class="fas fa-plus-circle me-2"></i>Nueva Asignación
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('coordinator.asignaciones.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Filtrar por Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-success w-100">Filtrar</button>
                </div>
                @if(request('fecha'))
                <div class="col-md-2 d-flex align-items-end">
                    <a href="{{ route('coordinator.asignaciones.index') }}" class="btn btn-link text-muted">Limpiar</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Fecha</th>
                        <th>Ruta</th>
                        <th>Camión / Placa</th>
                        <th>Conductor</th>
                        <th>Carga Est.</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($asignaciones as $asignacion)
                    <tr>
                        <td class="ps-4 fw-bold text-dark">
                            {{ \Carbon\Carbon::parse($asignacion->fecha)->format('d/m/Y') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 p-2 rounded me-3 text-success">
                                    <i class="fas fa-route"></i>
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $asignacion->ruta->nombre }}</div>
                                    <span class="text-muted small">{{ $asignacion->ruta->zona->nombre ?? 'Sin Zona'
                                        }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark border p-2">
                                <i class="fas fa-truck me-2"></i>{{ $asignacion->camion->placa }}
                            </span>
                        </td>
                        <td>
                            {{ $asignacion->conductor->nombre ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="text-success fw-bold">{{ number_format($asignacion->basura_estimada_ton, 2) }}
                                t</span>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-{{ $asignacion->estado->color ?? 'info' }} px-3">
                                {{ $asignacion->estado->nombre }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="#" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                <i class="fas fa-eye me-1"></i> Monitorear ruta
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="fas fa-calendar-times display-4 mb-3"></i>
                                <p>No hay rutas asignadas para los criterios seleccionados</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($asignaciones->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $asignaciones->links() }}
        </div>
        @endif
    </div>
</div>
@endsection