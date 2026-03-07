@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mb-4">panel de administración municipal</h1>


            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-primary h-100">
                        <div class="card-body">
                            <h5 class="card-title">denuncias ciudadanas</h5>
                            <p class="display-4 fw-bold text-primary">{{ $totalDenuncias }}</p>
                            <p class="text-muted">reportes totales en el sistema</p>
                            <a href="{{ route('admin.denuncias.index') }}" class="btn btn-primary px-4">gestionar
                                denuncias</a>
                        </div>
                    </div>
                </div>
                <!-- Gestión de Usuarios -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-dark h-100">
                        <div class="card-body">
                            <h5 class="card-title">gestión de personal</h5>
                            <p class="mb-3 text-muted">administra las cuentas y accesos del equipo municipal</p>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-dark px-4">gestionar
                                usuarios</a>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Roles -->
                <div class="col-md-6">
                    <div class="card shadow-sm border-secondary h-100">
                        <div class="card-body">
                            <h5 class="card-title">estructura de roles</h5>
                            <p class="mb-3 text-muted">configura niveles de acceso dinámicos del sistema</p>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary px-4">gestionar
                                roles</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection