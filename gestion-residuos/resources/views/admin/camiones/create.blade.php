@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">registrar camión de recolección</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.camiones.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="placa" class="form-label">placa del vehículo municipal</label>
                            <input type="text" name="placa" id="placa"
                                class="form-control @error('placa') is-invalid @enderror" value="{{ old('placa') }}"
                                required>
                            <small class="text-muted">ingrese la placa oficial de la unidad recolectora</small>
                            @error('placa')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="capacidad_toneladas" class="form-label">capacidad operativa (toneladas)</label>
                            <input type="number" step="0.1" name="capacidad_toneladas" id="capacidad_toneladas"
                                class="form-control @error('capacidad_toneladas') is-invalid @enderror"
                                value="{{ old('capacidad_toneladas') }}" required>
                            <small class="text-muted">especifique el peso máximo que puede cargar la unidad</small>
                            @error('capacidad_toneladas')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_estado_camion" class="form-label">estado inicial de la unidad</label>
                            <select name="id_estado_camion" id="id_estado_camion"
                                class="form-select @error('id_estado_camion') is-invalid @enderror" required>
                                @foreach($estados as $estado)
                                <option value="{{ $estado->id_estado_camion }}" {{ old('id_estado_camion')==$estado->
                                    id_estado_camion ? 'selected' : '' }}>
                                    {{ $estado->nombre }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">indique si el camión está listo para salir a ruta</small>
                            @error('id_estado_camion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold text-uppercase">Agregar camion</button>
                            <a href="{{ route('admin.camiones.index') }}" class="btn btn-light">cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection