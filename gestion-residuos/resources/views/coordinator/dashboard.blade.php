@extends('layouts.coordinator')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-dark">Panel Principal de Logística</h2>
            <p class="text-muted">Bienvenido, {{ auth()->user()->nombre }}. Gestione las rutas y la eficiencia de la
                recolección municipal .</p>
        </div>
    </div>

    @php
    $totalRutas = \App\Models\Ruta::count();
    $totalPeso = \App\Models\PuntoRecoleccion::sum('volumen_estimado_kg');
    @endphp

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3 bg-dark text-white rounded-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-signpost-2 text-warning" style="font-size: 2.5rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-uppercase small fw-bold mb-0">Total Rutas Trazadas</h6>
                        <h2 class="fw-bold mb-0">{{ $totalRutas }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-3 bg-warning text-dark rounded-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <i class="bi bi-boxes" style="font-size: 2.5rem;"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="text-uppercase small fw-bold mb-0">Basura Municipal Estimada (Total)</h6>
                        <h2 class="fw-bold mb-0">{{ number_format($totalPeso, 0) }} kg</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card card-coordinator shadow-sm text-center p-4 bg-white">
                <div class="mb-3">
                    <i class="bi bi-plus-square-fill text-warning" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold">Nueva Ruta</h4>
                <p class="text-muted">Diseñe y trace una nueva ruta de recolección en el mapa municipal .</p>
                <a href="{{ route('coordinator.rutas.create') }}" class="btn btn-dark w-100 fw-bold">TRAZAR RUTA</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-coordinator shadow-sm text-center p-4 bg-white">
                <div class="mb-3">
                    <i class="bi bi-list-columns-reverse text-warning" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold">Listado de Rutas</h4>
                <p class="text-muted">Consulte y gestione las rutas existentes y sus puntos de recolección municipal
                    .</p>
                <a href="{{ route('coordinator.rutas.index') }}" class="btn btn-dark w-100 fw-bold">VER LISTADO</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-coordinator shadow-sm text-center p-4 bg-white opacity-75">
                <div class="mb-3">
                    <i class="bi bi-truck text-muted" style="font-size: 3rem;"></i>
                </div>
                <h4 class="fw-bold text-muted">Asignación Camiones</h4>
                <p class="text-muted">Asigne recolectores a las rutas definidas (Módulo 1 - próximamente) municipal
                    .</p>
                <button class="btn btn-secondary w-100 fw-bold" disabled>PRÓXIMAMENTE</button>
            </div>
        </div>
    </div>
</div>
@endsection