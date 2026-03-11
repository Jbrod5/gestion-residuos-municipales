@extends('layouts.conductor')

@section('title', 'Mi Historial de Rutas')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="fw-bold">
                <i class="fas fa-history text-success me-2"></i>
                Mi Historial de Rutas
            </h2>
            <p class="text-muted">Todas las rutas que te han sido asignadas</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('conductor.dashboard') }}" class="btn btn-outline-success">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('conductor.asignaciones.index') }}" class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="1" {{ request('estado') == '1' ? 'selected' : '' }}>Programada</option>
                                <option value="2" {{ request('estado') == '2' ? 'selected' : '' }}>En Proceso</option>
                                <option value="3" {{ request('estado') == '3' ? 'selected' : '' }}>Completada</option>
                                <option value="4" {{ request('estado') == '4' ? 'selected' : '' }}>Incompleta</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha desde</label>
                            <input type="date" name="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha hasta</label>
                            <input type="date" name="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-success me-2">
                                <i class="fas fa-filter me-2"></i>Filtrar
                            </button>
                            <a href="{{ route('conductor.asignaciones.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo"></i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de asignaciones -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Ruta</th>
                                    <th>Zona</th>
                                    <th>Estado</th>
                                    <th>Horario</th>
                                    <th>Basura Estimada</th>
                                    <th>Basura Recolectada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asignaciones as $asignacion)
                                <tr>
                                    <td class="fw-bold">{{ $asignacion->id_asignacion_ruta }}</td>
                                    <td>{{ \Carbon\Carbon::parse($asignacion->fecha)->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $asignacion->ruta->nombre }}</strong>
                                    </td>
                                    <td>{{ $asignacion->ruta->zona->nombre ?? 'N/A' }}</td>
                                    <td>
                                        @if($asignacion->id_estado_asignacion_ruta == 1)
                                            <span class="badge bg-warning text-dark">Programada</span>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 2)
                                            <span class="badge bg-success">En Proceso</span>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 3)
                                            <span class="badge bg-info">Completada</span>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 4)
                                            <span class="badge bg-danger">Incompleta</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($asignacion->hora_inicio)
                                            <small>
                                                <i class="fas fa-play text-success me-1"></i>{{ $asignacion->hora_inicio }}<br>
                                                @if($asignacion->hora_fin)
                                                    <i class="fas fa-stop text-danger me-1"></i>{{ $asignacion->hora_fin }}
                                                @endif
                                            </small>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="text-end">{{ number_format($asignacion->basura_estimada_ton, 2) }} t</td>
                                    <td class="text-end">
                                        @if($asignacion->basura_recolectada_ton)
                                            <span class="fw-bold text-success">{{ number_format($asignacion->basura_recolectada_ton, 2) }} t</span>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('conductor.asignaciones.show', $asignacion->id_asignacion_ruta) }}" 
                                           class="btn btn-sm btn-outline-success" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($asignacion->id_estado_asignacion_ruta == 1)
                                            <a href="{{ route('conductor.asignaciones.iniciar', $asignacion->id_asignacion_ruta) }}" 
                                               class="btn btn-sm btn-success"
                                               onclick="return confirm('¿Iniciar esta ruta?')"
                                               title="Iniciar ruta">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        @elseif($asignacion->id_estado_asignacion_ruta == 2)
                                            <a href="{{ route('conductor.asignaciones.finalizar.form', $asignacion->id_asignacion_ruta) }}" 
                                               class="btn btn-sm btn-warning"
                                               title="Finalizar ruta">
                                                <i class="fas fa-flag-checkered"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <i class="fas fa-truck fa-4x text-muted mb-3"></i>
                                        <h5 class="text-muted">No tienes rutas asignadas</h5>
                                        <p class="text-muted">Cuando el coordinador te asigne rutas, aparecerán aquí</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(method_exists($asignaciones, 'links'))
                <div class="card-footer bg-white">
                    {{ $asignaciones->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection