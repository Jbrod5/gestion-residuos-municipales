@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mb-4">panel de administración municipal</h1>
            <p class="lead mb-5">gestión estratégica de residuos y servicios ciudadanos</p>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title">denuncias ciudadanas</h5>
                            <p class="display-4 fw-bold text-primary">{{ $totalDenuncias }}</p>
                            <p class="text-muted">reportes totales en el sistema</p>
                            <a href="{{ route('admin.denuncias.index') }}" class="btn btn-primary px-4">gestionar denuncias</a>
                        </div>
                    </div>
                </div>
                <!-- Otros modulos podrian ir aqui -->
            </div>
        </div>
    </div>
</div>
@endsection
