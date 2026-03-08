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
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Capacidad (m³)</th>
                            <th>Encargado</th>
                            <th>Horario</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($puntos as $punto)
                            <tr>
                                <td>#{{ $punto->id_punto_verde }}</td>
                                <td class="fw-bold">{{ $punto->nombre }}</td>
                                <td>{{ $punto->direccion }}</td>
                                <td>{{ $punto->capacidad_total_m3 }} m³</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $punto->encargado->nombre }}</span>
                                </td>
                                <td>
                                    @if($punto->horarios->count() > 0)
                                        <ul class="list-unstyled mb-0 small">
                                            @foreach($punto->horarios as $horario)
                                                <li><strong>{{ $horario->diaSemana->nombre }}:</strong> {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted italic">Sin horario asignado</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" title="Ver en mapa disabled">
                                        <i class="bi bi-geo-alt"></i>
                                    </button>
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
