@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Puntos Verdes de Reciclaje Municipal</h2>
        <a href="{{ route('admin.puntos-verdes.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i>Nuevo Punto Verde
        </a>
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
                            <th>ID (#id)</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Encargado</th>
                            <th>Capacidad Total (m³)</th>
                            <th>Estado de Llenado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($puntos as $punto)
                            @php
                                $totalCapacidad = $punto->contenedores->sum('capacidad_maxima_m3');
                                $totalNivel = $punto->contenedores->sum('nivel_actual_m3');
                                $porcentaje = $totalCapacidad > 0 ? ($totalNivel / $totalCapacidad) * 100 : 0;
                            @endphp
                            <tr>
                                <td>#{{ $punto->id_punto_verde }}</td>
                                <td class="fw-bold">{{ $punto->nombre }}</td>
                                <td>{{ $punto->direccion }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $punto->encargado->nombre }}</span>
                                </td>
                                <td>{{ number_format($punto->capacidad_total_m3, 1) }} m³</td>
                                <td style="width: 200px;">
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar {{ $porcentaje > 80 ? 'bg-danger' : ($porcentaje > 50 ? 'bg-warning' : 'bg-success') }}" 
                                             role="progressbar" style="width: {{ $porcentaje }}%;" 
                                             aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                                            {{ number_format($porcentaje, 1) }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.puntos-verdes.edit', $punto->id_punto_verde) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.puntos-verdes.destroy', $punto->id_punto_verde) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta infraestructura municipal?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
