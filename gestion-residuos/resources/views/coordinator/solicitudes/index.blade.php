@extends('layouts.coordinator')

@section('title', 'Solicitudes de Vaciado')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4 align-items-center">
        <div class="col-md-8">
            <h2 class="mb-0 text-primary fw-bold">solicitudes de vaciado de puntos verdes</h2>
            <p class="text-muted mb-0">revisión y confirmación de vaciados en una sola ejecución</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Punto Verde</th>
                            <th>Contenedor / Material</th>
                            <th>Fecha de Solicitud</th>
                            <th class="text-end">Nivel actual (m³)</th>
                            <th class="text-center">Estado</th>
                            <th class="text-end pe-4">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($solicitudes as $solicitud)
                        @php
                            $contenedor = $solicitud->contenedor;
                            $material = optional($contenedor->material)->nombre ?? 'sin material';
                            $nivel = $contenedor->nivel_actual_m3 ?? 0;
                            $badgeEstado = $solicitud->estado === 'Pendiente' ? 'bg-warning text-dark' : 'bg-success';
                        @endphp
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold">{{ $solicitud->puntoVerde->nombre ?? 'sin punto verde' }}</div>
                                <div class="text-muted small">
                                    {{ $solicitud->puntoVerde->direccion ?? '' }}
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $material }}</div>
                                <div class="text-muted small">
                                    contenedor #{{ $contenedor->id_contenedor ?? 'N/A' }}
                                </div>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y H:i') }}
                            </td>
                            <td class="text-end">
                                <span class="fw-bold">{{ number_format($nivel, 2) }}</span>
                                <span class="text-muted">m³</span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $badgeEstado }}">
                                    {{ strtolower($solicitud->estado) }}
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('coordinator.solicitudes.atender', $solicitud->id_solicitud) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success px-3">
                                        <i class="bi bi-check2-circle me-1"></i>confirmar vaciado
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox display-5 mb-3"></i>
                                    <p class="mb-0">no hay solicitudes de vaciado pendientes</p>
                                </div>
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

