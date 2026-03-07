@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">equipo: {{ $cuadrilla->nombre }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>zona municipal:</strong> {{ $cuadrilla->zona->nombre ?? 'N/A' }}</p>
                    <p><strong>unidad recolección:</strong> {{ $cuadrilla->camion->placa ?? 'N/A' }}</p>
                    <hr>
                    <h6 class="text-uppercase small fw-bold">personal vinculado</h6>
                    <ul class="list-group list-group-flush">
                        @forelse($cuadrilla->trabajadores as $trabajador)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                {{ $trabajador->nombre }}
                                <form action="{{ route('admin.cuadrillas.desasignar', [$cuadrilla->id_cuadrilla, $trabajador->id_usuario]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm text-danger" title="remover del equipo">
                                        <i class="bi bi-person-x"></i> quitar
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="list-group-item text-muted small px-0">sin personal operativo aún</li>
                        @endforelse
                    </ul>
                </div>
            </div>
            <a href="{{ route('admin.cuadrillas.index') }}" class="btn btn-outline-secondary w-100">volver al listado</a>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">asignar personal operativo municipal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cuadrillas.asignar', $cuadrilla->id_cuadrilla) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="id_usuario" class="form-label">seleccione trabajador administrativo/operativo</label>
                            <select name="id_usuario" id="id_usuario" class="form-select @error('id_usuario') is-invalid @enderror" required>
                                <option value="" selected disabled>elija un empleado municipal</option>
                                @foreach($empleadosDisponibles as $empleado)
                                    <option value="{{ $empleado->id_usuario }}">
                                        {{ $empleado->nombre }} ({{ $empleado->correo }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">seleccione al trabajador que desea sumar al equipo de limpieza</small>
                            @error('id_usuario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold">vincular al equipo municipal</button>
                        </div>
                    </form>
                </div>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
