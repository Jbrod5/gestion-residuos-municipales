@extends('layouts.citizen')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detalle de Denuncia #{{ $denuncia->id_denuncia }}</h2>
        <a href="{{ route('ciudadano.denuncias.index') }}" class="btn btn-secondary">volver al listado</a>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Información General</h5>
                </div>
                <div class="card-body">
                    <p><strong>Descripción:</strong><br>{{ $denuncia->descripcion }}</p>
                    <p><strong>Tamaño:</strong> {{ $denuncia->tamano->nombre }}</p>
                    <p><strong>Estado:</strong> 
                        <span class="badge @if($denuncia->estado->nombre == 'Pendiente') bg-warning @elseif($denuncia->estado->nombre == 'En Revisión') bg-info @else bg-success @endif">
                            {{ $denuncia->estado->nombre }}
                        </span>
                    </p>
                    <p><strong>Fecha de Reporte:</strong> {{ $denuncia->created_at->format('d/m/Y H:i') }}</p>
                    
                    <hr>
                    
                    <h5 class="mt-4">Ubicación</h5>
                    <p><strong>Latitud:</strong> {{ $denuncia->latitud ?? 'N/A' }}</p>
                    <p><strong>Longitud:</strong> {{ $denuncia->longitud ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-dark text-white">
                    <h5 class="card-title mb-0">Evidencia Fotográfica</h5>
                </div>
                <div class="card-body text-center">
                    @if($denuncia->foto_antes)
                        <h6>Foto Antes de la Atención:</h6>
                        <img src="{{ asset('storage/' . $denuncia->foto_antes) }}" class="img-fluid rounded shadow-sm mb-3" alt="Evidencia de la denuncia">
                    @else
                        <div class="alert alert-light border">no se adjuntó foto original</div>
                    @endif

                    @if($denuncia->foto_despues)
                        <h6 class="mt-4">Foto Después de la Atención:</h6>
                        <img src="{{ asset('storage/' . $denuncia->foto_despues) }}" class="img-fluid rounded shadow-sm" alt="Foto de resolución">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
