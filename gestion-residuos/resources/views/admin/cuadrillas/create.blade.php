@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">organizar cuadrilla municipal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.cuadrillas.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">alias o nombre del equipo</label>
                            <input type="text" name="nombre" id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                                required>
                            <small class="text-muted">ingrese un nombre distintivo para la cuadrilla municipal</small>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_camion" class="form-label">asignar camión recolector</label>
                            <select name="id_camion" id="id_camion"
                                class="form-select @error('id_camion') is-invalid @enderror">
                                <option value="" selected disabled>seleccione unidad disponible</option>
                                @foreach($camionesDisponibles as $camion)
                                <option value="{{ $camion->id_camion }}" {{ old('id_camion')==$camion->id_camion ?
                                    'selected' : '' }}>
                                    {{ $camion->placa }} ({{ $camion->capacidad_toneladas }} ton)
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">solo aparecen unidades operativas y sin cuadrilla municipal
                                asignada</small>
                            @error('id_camion')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="id_zona" class="form-label">zona de limpieza municipal</label>
                            <select name="id_zona" id="id_zona"
                                class="form-select @error('id_zona') is-invalid @enderror">
                                <option value="" selected disabled>fijar zona operativa</option>
                                @foreach($zonas as $zona)
                                <option value="{{ $zona->id_zona }}" {{ old('id_zona')==$zona->id_zona ? 'selected' : ''
                                    }}>
                                    {{ $zona->nombre }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">seleccione el sector o zona donde trabajará el equipo</small>
                            @error('id_zona')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-dark text-uppercase fw-bold">activar equipo de
                                limpieza</button>
                            <a href="{{ route('admin.cuadrillas.index') }}" class="btn btn-light">cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection