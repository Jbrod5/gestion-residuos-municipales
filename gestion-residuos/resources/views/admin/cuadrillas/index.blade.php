@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>gestión de cuadrillas de limpieza</h2>
        <a href="{{ route('admin.cuadrillas.create') }}" class="btn btn-dark">organizar nueva cuadrilla</a>
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
                            <th>ID correlativo</th>
                            <th>nombre del equipo (alias)</th>
                            <th>zona asignada</th>
                            <th>unidad operativa</th>
                            <th>personal activo</th>
                            <th>estado</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cuadrillas as $cuadrilla)
                            <tr>
                                <td>#{{ $cuadrilla->id_cuadrilla }}</td>
                                <td class="fw-bold">{{ $cuadrilla->nombre }}</td>
                                <td>{{ $cuadrilla->zona->nombre ?? 'zona no definida' }}</td>
                                <td>{{ $cuadrilla->camion->placa ?? 'unidas sin camión' }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $cuadrilla->trabajadores->count() }} operarios</span>
                                </td>
                                <td>
                                    @if($cuadrilla->disponible)
                                        <span class="badge bg-success">OPERATIVA</span>
                                    @else
                                        <span class="badge bg-danger">NO DISPONIBLE</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.cuadrillas.personal', $cuadrilla->id_cuadrilla) }}" class="btn btn-sm btn-outline-primary">gestionar personal</a>
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
