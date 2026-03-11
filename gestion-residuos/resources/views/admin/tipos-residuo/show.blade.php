@extends('layouts.admin')

@section('title', 'Detalles del Tipo de Residuo')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-info py-3">
                    <h5 class="mb-0 text-white fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        Detalles del Tipo de Residuo
                    </h5>
                </div>
                
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th style="width: 200px;">ID:</th>
                            <td>#{{ $tipo->id_tipo_residuo }}</td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td>
                                <span class="badge bg-success p-2">{{ $tipo->nombre }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Descripción:</th>
                            <td>{{ $tipo->descripcion ?? 'Sin descripción' }}</td>
                        </tr>
                        <tr>
                            <th>Total Rutas:</th>
                            <td>{{ $estadisticas['total_rutas'] }} rutas</td>
                        </tr>
                        <tr>
                            <th>Total Asignaciones:</th>
                            <td>{{ $estadisticas['total_asignaciones'] }} recolecciones</td>
                        </tr>
                        <tr>
                            <th>Último uso:</th>
                            <td>
                                @if(!empty($estadisticas['ultimo_uso']))
                                    {{ $estadisticas['ultimo_uso']->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">Nunca usado</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Fecha creación:</th>
                            <td>
                                @if($tipo->created_at)
                                    {{ $tipo->created_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Última actualización:</th>
                            <td>
                                @if($tipo->updated_at)
                                    {{ $tipo->updated_at->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    <!-- Lista de rutas que usan este tipo -->
                    @if($tipo->rutas && $tipo->rutas->count() > 0)
                    <h6 class="mt-4 mb-3">Rutas que usan este tipo:</h6>
                    <ul class="list-group">
                        @foreach($tipo->rutas as $ruta)
                        <li class="list-group-item">
                            <i class="fas fa-route text-success me-2"></i>
                            {{ $ruta->nombre }}
                            <small class="text-muted float-end">
                                @if(isset($ruta->asignaciones))
                                    {{ $ruta->asignaciones->count() }} asignaciones
                                @else
                                    0 asignaciones
                                @endif
                            </small>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                
                <div class="card-footer bg-white">
                    <a href="{{ route('admin.tipos-residuo.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('admin.tipos-residuo.edit', $tipo->id_tipo_residuo) }}" 
                       class="btn btn-warning float-end">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection