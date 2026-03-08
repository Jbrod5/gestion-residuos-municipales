@extends('layouts.operator')

@section('content')
<div class="row mb-3">
    <div class="col-md-12">
        <h2 class="mb-1 fw-bold">historial de movimientos</h2>
        <small class="text-muted">entradas de material y vaciados de contenedores</small>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label for="fecha_desde" class="form-label">desde</label>
                <input type="date" id="fecha_desde" name="fecha_desde" class="form-control"
                       value="{{ $fechaDesde }}">
            </div>
            <div class="col-md-4">
                <label for="fecha_hasta" class="form-label">hasta</label>
                <input type="date" id="fecha_hasta" name="fecha_hasta" class="form-control"
                       value="{{ $fechaHasta }}">
            </div>
            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-funnel me-1"></i>filtrar
                </button>
                <a href="{{ route('operador.historial.index') }}" class="btn btn-outline-secondary flex-fill">
                    limpiar
                </a>
            </div>
        </form>
        <small class="text-muted d-block mt-2">se muestran máximo 50 registros, del más reciente al más antiguo</small>
    </div>
</div>

@if($historial->isEmpty())
<div class="alert alert-info">
    no hay movimientos registrados en el rango seleccionado
</div>
@else
<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-nowrap">Fecha</th>
                        <th>Material</th>
                        <th class="text-center">Movimiento</th>
                        <th class="text-end">Cantidad</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($historial as $mov)
                    <tr>
                        <td class="text-nowrap">
                            {{ $mov->fecha->format('d/m/Y H:i') }}
                        </td>
                        <td>{{ $mov->material }}</td>
                        <td class="text-center">
                            @if($mov->movimiento === 'Entrada')
                                <span class="badge bg-success">entrada</span>
                            @else
                                <span class="badge bg-danger">salida</span>
                            @endif
                        </td>
                        <td class="text-end">
                            {{ number_format($mov->cantidad_valor, 2) }}
                            <span class="text-muted">{{ $mov->cantidad_unidad }}</span>
                        </td>
                        <td>{{ $mov->observaciones }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@endsection

