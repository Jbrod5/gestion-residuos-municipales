@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Roles municipales del sistema de gestión de desechos</h2>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-dark">nuevo rol municipal</a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID</th>
                            <th>nombre del rol</th>
                            <th>descripción administrativa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $rol)
                        <tr>
                            <td>{{ $rol->id_rol }}</td>
                            <td class="fw-bold">{{ $rol->nombre }}</td>
                            <td>{{ $rol->descripcion }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">volver al panel principal</a>
    </div>
</div>
@endsection