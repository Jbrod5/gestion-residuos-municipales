@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mb-4">panel de administración municipal</h1>


            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title">denuncias ciudadanas</h5>
                            <p class="display-4 fw-bold text-primary">{{ $totalDenuncias }}</p>
                            <p class="text-muted small">reportes totales en el sistema</p>
                            <a href="{{ route('admin.denuncias.index') }}" class="btn btn-primary w-100">gestionar reportes</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-dark h-100">
                        <div class="card-body">
                            <h5 class="card-title">logística camiones</h5>
                            <p class="mb-3 text-muted small">gestiona la flota de recolección municipal</p>
                            <div class="d-grid">
                                <a href="{{ route('admin.camiones.index') }}" class="btn btn-dark mb-2">ver flota</a>
                                <a href="{{ route('admin.camiones.create') }}" class="btn btn-outline-dark btn-sm">nuevo camión</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title">cuadrillas y personal</h5>
                            <p class="mb-3 text-muted small">organiza equipos de barrido y recolección</p>
                            <div class="d-grid">
                                <a href="{{ route('admin.cuadrillas.index') }}" class="btn btn-secondary mb-2">ver cuadrillas</a>
                                <a href="{{ route('admin.cuadrillas.create') }}" class="btn btn-outline-secondary btn-sm">organizar equipo</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-dark h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">gestión de usuarios</h5>
                                <p class="text-muted small mb-0">administra cuentas del personal</p>
                            </div>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-sm btn-dark">ir a usuarios</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-secondary h-100">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">estructura de roles</h5>
                                <p class="text-muted small mb-0">configura niveles dinámicos</p>
                            </div>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-sm btn-outline-secondary">ir a roles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection