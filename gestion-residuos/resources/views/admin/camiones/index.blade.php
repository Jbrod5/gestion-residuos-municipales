@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>flota de camiones municipales</h2>
        <a href="{{ route('admin.camiones.create') }}" class="btn btn-primary">nuevo camión municipal</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>placa municipal</th>
                            <th>capacidad (ton)</th>
                            <th>estado operativo</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($camiones as $camion)
                            <tr>
                                <td>#{{ $camion->id_camion }}</td>
                                <td class="fw-bold">{{ $camion->placa }}</td>
                                <td>{{ $camion->capacidad_toneladas }}</td>
                                <td>
                                    @php
                                        $badgeColor = match($camion->id_estado_camion) {
                                            1 => 'success',
                                            2 => 'warning',
                                            3 => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }}">{{ $camion->estado->nombre }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.camiones.edit', $camion->id_camion) }}" class="btn btn-sm btn-outline-dark">editar unidad</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
