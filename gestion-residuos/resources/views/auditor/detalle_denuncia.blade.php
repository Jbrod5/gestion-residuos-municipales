@extends('layouts.auditor')

@section('title', 'Verificación de denuncia')

@section('content')
<div class="row">
    <div class="col-md-7 mb-4">
        <div class="card mb-3">
            <div class="card-header">Datos generales de la denuncia</div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Fecha</dt>
                    <dd class="col-sm-8">{{ $denuncia->fecha }}</dd>

                    <dt class="col-sm-4">Ciudadano</dt>
                    <dd class="col-sm-8">{{ $denuncia->usuario?->nombre }}</dd>

                    <dt class="col-sm-4">Estado</dt>
                    <dd class="col-sm-8">{{ $denuncia->estado?->nombre }}</dd>

                    <dt class="col-sm-4">Tamaño</dt>
                    <dd class="col-sm-8">{{ $denuncia->tamano?->nombre }}</dd>

                    <dt class="col-sm-4">Descripción</dt>
                    <dd class="col-sm-8">{{ $denuncia->descripcion }}</dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Ubicación aproximada</div>
            <div class="card-body">
                @if ($denuncia->latitud && $denuncia->longitud)
                    <p class="mb-0">Latitud: {{ $denuncia->latitud }} Longitud: {{ $denuncia->longitud }}</p>
                @else
                    <p class="text-muted mb-0">Sin coordenadas registradas</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-5 mb-4">
        <div class="card mb-3">
            <div class="card-header">Foto antes de la atención</div>
            <div class="card-body text-center">
                @if ($denuncia->foto_antes)
                    <img src="{{ asset('storage/' . $denuncia->foto_antes) }}" alt="Foto antes" class="img-fluid rounded">
                @else
                    <p class="text-muted mb-0">Sin foto de antes registrada</p>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">Foto después de la atención</div>
            <div class="card-body text-center">
                @if ($denuncia->foto_despues)
                    <img src="{{ asset('storage/' . $denuncia->foto_despues) }}" alt="Foto despues" class="img-fluid rounded">
                @else
                    <p class="text-muted mb-0">Sin foto de después registrada</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

