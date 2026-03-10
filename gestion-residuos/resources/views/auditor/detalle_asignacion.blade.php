@extends('layouts.auditor')

@section('title', 'Detalle de asignación de ruta')

@section('content')
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">Resumen de ruta y recolección</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Ruta</dt>
                    <dd class="col-sm-8">{{ $asignacion->ruta?->nombre }}</dd>

                    <dt class="col-sm-4">Zona</dt>
                    <dd class="col-sm-8">{{ $asignacion->ruta?->zona?->nombre }}</dd>

                    <dt class="col-sm-4">Fecha</dt>
                    <dd class="col-sm-8">{{ $asignacion->fecha }}</dd>

                    <dt class="col-sm-4">Estado</dt>
                    <dd class="col-sm-8">
                        <span class="badge bg-{{ $asignacion->estado?->color ?? 'secondary' }}">
                            {{ $asignacion->estado?->nombre }}
                        </span>
                    </dd>

                    <dt class="col-sm-4">Basura estimada (t)</dt>
                    <dd class="col-sm-8">{{ $asignacion->basura_estimada_ton }}</dd>

                    <dt class="col-sm-4">Basura recolectada (t)</dt>
                    <dd class="col-sm-8">{{ $asignacion->basura_recolectada_ton ?? 'No reportado' }}</dd>
                </dl>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Incidencias reportadas por el conductor</div>
            <div class="card-body">
                @if ($asignacion->notas_incidencias)
                    <p class="mb-0">{{ $asignacion->notas_incidencias }}</p>
                @else
                    <p class="text-muted mb-0">Sin incidencias registradas</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card mb-3">
            <div class="card-header">Datos del camión</div>
            <div class="card-body">
                <p class="mb-1"><strong>Placa:</strong> {{ $asignacion->camion?->placa }}</p>
                <p class="mb-1"><strong>Capacidad:</strong> {{ $asignacion->camion?->capacidad_toneladas }} t</p>
                <p class="mb-1"><strong>Estado:</strong> {{ $asignacion->camion?->estado?->nombre }}</p>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Datos de cuadrilla y conductor</div>
            <div class="card-body">
                <p class="mb-1"><strong>Cuadrilla:</strong> {{ $asignacion->cuadrilla?->nombre ?? 'No asignada' }}</p>
                <p class="mb-1"><strong>Conductor:</strong> {{ $asignacion->conductor?->nombre ?? 'No asignado' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

