@extends('layouts.operator')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2 class="mb-1 fw-bold">gestión de punto verde</h2>
    </div>
</div>

{{-- alertas de sesion --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(!$puntoVerde)
{{-- caso sin punto verde asignado --}}
<div class="row mt-5">
    <div class="col-md-12 text-center">
        <p class="text-muted fs-5"><i class="bi bi-info-circle me-2"></i>No tiene un Punto Verde asignado</p>
    </div>
</div>

@else
{{-- info del punto verde --}}
<div class="card shadow-sm mb-4">
    <div class="card-body d-flex align-items-center gap-3">
        <i class="bi bi-recycle fs-3 text-success"></i>
        <div>
            <h5 class="fw-bold mb-0">{{ $puntoVerde->nombre }}</h5>
            <small class="text-muted"><i class="bi bi-geo-alt-fill"></i> {{ $puntoVerde->direccion }}</small>
        </div>
    </div>
</div>

{{-- control de contenedores --}}
<h5 class="fw-bold border-bottom pb-2 mb-3">control de contenedores</h5>

@if($inventario->isEmpty())
<div class="alert alert-info">este punto verde aún no tiene contenedores configurados</div>
@else
<div class="row">
    @foreach($inventario as $item)
    @php
        // colores y etiquetas según nivel de alerta
        $color = match($item->estado_alerta) {
            'lleno'       => 'danger',
            'critico'     => 'danger',
            'advertencia' => 'warning',
            default       => 'success',
        };
        $badgeColor = match($item->estado_alerta) {
            'lleno'       => 'bg-danger',
            'critico'     => 'bg-danger',
            'advertencia' => 'bg-warning text-dark',
            default       => 'bg-success',
        };
        $etiqueta = match($item->estado_alerta) {
            'lleno'       => 'lleno',
            'critico'     => 'urgente',
            'advertencia' => 'alerta',
            default       => 'normal',
        };
    @endphp
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-{{ $color }}">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title fw-bold mb-0">{{ $item->material->nombre }}</h6>
                    <span class="badge {{ $badgeColor }}">{{ $etiqueta }}</span>
                </div>

                <div class="progress mb-2" style="height: 14px;">
                    <div class="progress-bar bg-{{ $color }}"
                         role="progressbar"
                         style="width: {{ $item->porcentaje_llenado }}%"
                         aria-valuenow="{{ $item->porcentaje_llenado }}"
                         aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                <div class="d-flex justify-content-between small text-muted mb-3">
                    <span><strong>{{ round($item->nivel_actual_m3, 2) }}</strong> m³ actual</span>
                    <span><strong>{{ $item->porcentaje_llenado }}%</strong></span>
                    <span>cap: <strong>{{ $item->capacidad_maxima_m3 }}</strong> m³</span>
                </div>

                {{-- mensaje contextual por nivel --}}
                @if($item->estado_alerta === 'lleno')
                <div class="alert alert-danger py-1 px-2 small mb-2">
                    <i class="bi bi-exclamation-octagon-fill me-1"></i>contenedor lleno, requiere atención inmediata
                </div>
                @elseif($item->estado_alerta === 'critico')
                <div class="alert alert-danger py-1 px-2 small mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>nivel crítico (≥90%), vaciado urgente
                </div>
                @elseif($item->estado_alerta === 'advertencia')
                <div class="alert alert-warning py-1 px-2 small mb-2">
                    <i class="bi bi-exclamation-circle-fill me-1"></i>alerta temprana: nivel al 75%
                </div>
                @endif

                {{-- boton de solicitar vaciado ya está en alerta amarilla --}}
                @if($item->porcentaje_llenado >= 75)
                <form action="{{ route('operador.vaciado.solicitar', $item->id_contenedor) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-bell-fill me-1"></i>solicitar vaciado
                    </button>
                </form>
                @else
                <button class="btn btn-outline-secondary btn-sm w-100 disabled">
                    <i class="bi bi-check-circle me-1"></i>estado correcto
                </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- formulario de registro de entrega --}}
<h5 class="fw-bold border-bottom pb-2 mt-4 mb-3">registrar entrega de material</h5>
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('operador.entrega.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="id_material" class="form-label">material</label>
                    <select name="id_material" id="id_material"
                        class="form-select @error('id_material') is-invalid @enderror" required>
                        <option value="" disabled selected>seleccione material</option>
                        @foreach($inventario as $item)
                        <option value="{{ $item->id_material }}" {{ old('id_material') == $item->id_material ? 'selected' : '' }}>
                            {{ $item->material->nombre }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_material')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-3">
                    <label for="cantidad_kg" class="form-label">cantidad (kg)</label>
                    <input type="number" step="0.01" min="0.01" name="cantidad_kg" id="cantidad_kg"
                        class="form-control @error('cantidad_kg') is-invalid @enderror"
                        value="{{ old('cantidad_kg') }}" required>
                    @error('cantidad_kg')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="observaciones" class="form-label">observaciones (opcional)</label>
                    <input type="text" name="observaciones" id="observaciones"
                        class="form-control"
                        value="{{ old('observaciones') }}"
                        placeholder="ej: bolsa incompleta, material húmedo...">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-lg"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

@endsection
