@extends('layouts.coordinator')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="bi bi-signpost-split-fill me-2 text-warning"></i>Rutas de Recolección Municipal
        </h2>
        <a href="{{ route('coordinator.rutas.create') }}" class="btn btn-warning fw-bold">
            <i class="bi bi-plus-circle me-1"></i>TRAZAR NUEVA RUTA
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success shadow-sm border-0">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th class="ps-3">ID (#)</th>
                            <th>Nombre de Ruta</th>
                            <th>Zona</th>
                            <th>Tipo Residuo</th>
                            <th>Distancia (km)</th>
                            <th>Peso Total (kg)</th>
                            <th>Puntos de Recolección</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rutas as $ruta)
                        <tr>
                            <td class="ps-3 fw-bold text-muted">#{{ $ruta->id_ruta }}</td>
                            <td class="fw-bold">{{ $ruta->nombre }}</td>
                            <td><span class="badge bg-secondary">{{ $ruta->zona->nombre }}</span></td>
                            <td>{{ $ruta->tipoResiduo->nombre }}</td>
                            <td>{{ number_format($ruta->distancia_km, 2) }} km</td>
                            <td class="fw-bold text-success">{{ number_format($ruta->pesoTotalEstimadoKg(), 0) }} kg</td>
                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $ruta->puntos_recoleccion_count ?? $ruta->puntosRecoleccion->count() }} puntos
                                    sembrados
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('coordinator.rutas.show', $ruta->id_ruta) }}"
                                    class="btn btn-sm btn-outline-dark fw-bold">
                                    <i class="bi bi-eye-fill me-1"></i> VER DETALLE
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-info-circle me-2"></i>No hay rutas trazadas actualmente municipal .
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection