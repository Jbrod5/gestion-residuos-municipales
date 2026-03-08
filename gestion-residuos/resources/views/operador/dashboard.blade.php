@extends('layouts.operator')

@section('content')
<div class="row mb-4">
    <div class="col-md-12">
        <h2 class="mb-1 fw-bold">Gestión de Punto Verde municipal</h2>
    </div>
</div>

@if(!$puntoVerde)
<div class="row mt-5">
    <div class="col-md-12 text-center">
        <p class="text-muted fs-5"><i class="bi bi-info-circle me-2"></i> No tiene un Punto Verde asignado municipal</p>
    </div>
</div>
@else
<div class="row mb-5">
    <div class="col-md-12">
        <div class="bg-white p-4 border rounded shadow-sm">
            <h4 class="fw-bold text-dark mb-1">{{ $puntoVerde->nombre }}</h4>
            <p class="text-secondary mb-0"><i class="bi bi-geo-alt-fill text-success"></i> {{ $puntoVerde->direccion }}</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <h5 class="fw-bold border-bottom pb-2">Inventario por Material municipal</h5>
    </div>
    @foreach($inventario as $item)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 shadow-sm border-light">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0 fw-bold text-dark">{{ $item->material->nombre }}</h5>
                    <span class="badge {{ $item->porcentaje_llenado >= 90 ? 'bg-danger' : 'bg-success' }}">
                        {{ $item->porcentaje_llenado }}% municipal
                    </span>
                </div>
                
                <div class="progress mb-4" style="height: 12px;">
                    <div class="progress-bar {{ $item->porcentaje_llenado >= 90 ? 'bg-danger' : 'bg-success' }}" 
                         role="progressbar" 
                         style="width: {{ $item->porcentaje_llenado }}%" 
                         aria-valuenow="{{ $item->porcentaje_llenado }}" 
                         aria-valuemin="0" 
                         aria-valuemax="100">
                    </div>
                </div>

                <div class="d-flex justify-content-between mb-4 small text-muted">
                    <span><strong>{{ round($item->nivel_actual_m3, 2) }}</strong> m³ actual</span>
                    <span>Capacidad: <strong>{{ $item->capacidad_maxima_m3 }}</strong> m³</span>
                </div>

                @if($item->necesita_vaciado)
                <form action="{{ route('operador.vaciado.solicitar', $item->id_contenedor) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 fw-bold py-2">
                        <i class="bi bi-bell-fill me-2"></i>Notificar Vaciado Municipal
                    </button>
                </form>
                @else
                <button class="btn btn-outline-secondary w-100 disabled py-2">
                    <i class="bi bi-check-circle me-2"></i>Estado Correcto Municipal
                </button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>

<div class="row mt-4 mb-5">
    <div class="col-md-12 text-center">
        <a href="{{ route('operador.entrega.create') }}" class="btn btn-success btn-lg px-5 shadow-sm py-3 fw-bold">
            <i class="bi bi-plus-lg me-2"></i>REGISTRAR ENTREGA MUNICIPAL
        </a>
    </div>
</div>
@endif
@endsection
