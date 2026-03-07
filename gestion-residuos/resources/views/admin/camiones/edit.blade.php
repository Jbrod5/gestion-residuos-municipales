@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">editar camión municipal: {{ $camion->placa }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.camiones.update', $camion->id_camion) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-3">
                            <label for="placa" class="form-label">placa municipal</label>
                            <input type="text" name="placa" id="placa" class="form-control @error('placa') is-invalid @enderror" value="{{ old('placa', $camion->placa) }}" required>
                            <small class="text-muted">actualice la placa si hubo cambios administrativos</small>
                            @error('placa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="capacidad_toneladas" class="form-label">capacidad (toneladas)</label>
                            <input type="number" step="0.1" name="capacidad_toneladas" id="capacidad_toneladas" class="form-control @error('capacidad_toneladas') is-invalid @enderror" value="{{ old('capacidad_toneladas', $camion->capacidad_toneladas) }}" required>
                            <small class="text-muted">modifique la capacidad de carga del vehículo</small>
                            @error('capacidad_toneladas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_estado_camion" class="form-label">estado operativo actual</label>
                            <select name="id_estado_camion" id="id_estado_camion" class="form-select @error('id_estado_camion') is-invalid @enderror" required>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado->id_estado_camion }}" {{ old('id_estado_camion', $camion->id_estado_camion) == $estado->id_estado_camion ? 'selected' : '' }}>
                                        {{ $estado->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted">cambie la disponibilidad operativa de la unidad</small>
                            @error('id_estado_camion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark fw-bold">actualizar unidad municipal</button>
                            <a href="{{ route('admin.camiones.index') }}" class="btn btn-light">cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
