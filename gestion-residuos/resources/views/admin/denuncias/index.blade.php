{{-- Cambiar el layout de admin a coordinator --}}
@extends('layouts.coordinator')  {{-- ANTES: layouts.admin --}}

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Denuncias - Coordinador</h2>  {{-- Título más específico --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Ciudadano</th>
                            <th>Tamaño</th>
                            <th>Estado actual</th>
                            <th>Fecha</th>
                            <th>Acciones</th>  {{-- Cambiar título --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denuncias as $denuncia)
                            <tr>
                                <td>#{{ $denuncia->id_denuncia }}</td>
                                <td>{{ $denuncia->usuario->nombre }}</td>
                                <td>{{ $denuncia->tamano->nombre }}</td>
                                <td>
                                    <span class="badge @if($denuncia->estado->nombre == 'Pendiente') bg-warning @elseif($denuncia->estado->nombre == 'En Revisión') bg-info @else bg-success @endif">
                                        {{ $denuncia->estado->nombre }}
                                    </span>
                                </td>
                                <td>{{ $denuncia->created_at->format('d/m/Y') }}</td>
                                <td class="d-flex gap-2">
                                    {{-- Cambiar route de admin a coordinator --}}
                                    <form action="{{ route('coordinator.denuncias.update', $denuncia->id_denuncia) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="id_estado_denuncia" class="form-select form-select-sm" required>
                                            @foreach($estados as $estado)
                                                <option value="{{ $estado->id_estado_denuncia }}" {{ $denuncia->id_estado_denuncia == $estado->id_estado_denuncia ? 'selected' : '' }}>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-success">Actualizar</button>
                                    </form>

                                    @if($denuncia->id_estado_denuncia == 1 || $denuncia->id_estado_denuncia == 2)
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAsignar{{ $denuncia->id_denuncia }}">
                                            Asignar cuadrilla
                                        </button>

                                        <!-- Modal de Asignación -->
                                        <div class="modal fade" id="modalAsignar{{ $denuncia->id_denuncia }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title">Asignar cuadrilla a denuncia #{{ $denuncia->id_denuncia }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    {{-- Cambiar route de admin a coordinator --}}
                                                    <form action="{{ route('coordinator.asignaciones.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id_denuncia" value="{{ $denuncia->id_denuncia }}">
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Seleccione cuadrilla disponible</label>
                                                                <select name="id_cuadrilla" class="form-select" required>
                                                                    <option value="" selected disabled>Elija un equipo municipal</option>
                                                                    @foreach($cuadrillasDisponibles as $cuadrilla)
                                                                        <option value="{{ $cuadrilla->id_cuadrilla }}">
                                                                            {{ $cuadrilla->nombre }} (Zona: {{ $cuadrilla->zona->nombre ?? 'N/A' }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <small class="text-muted d-block mt-2">Solo se muestran cuadrillas marcadas como disponibles</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Confirmar asignación</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($denuncia->id_estado_denuncia == 4)
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalFinalizar{{ $denuncia->id_denuncia }}">
                                            Finalizar denuncia
                                        </button>

                                        <!-- Modal de Finalización -->
                                        <div class="modal fade" id="modalFinalizar{{ $denuncia->id_denuncia }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title">Finalizar ciclo operativo #{{ $denuncia->id_denuncia }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    {{-- Cambiar route de admin a coordinator --}}
                                                    <form action="{{ route('coordinator.denuncias.finalizar', $denuncia->id_denuncia) }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label fw-bold">Evidencia visual (foto después)</label>
                                                                <input type="file" name="foto_despues" class="form-control" accept="image/*" required>
                                                                <small class="text-muted d-block mt-2">Suba una imagen clara del lugar ya limpio</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-success">Confirmar finalización</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        {{-- Cambiar a dashboard del coordinador --}}
        <a href="{{ route('coordinator.dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver al dashboard
        </a>
    </div>
</div>
@endsection