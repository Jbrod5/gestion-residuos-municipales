@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">crear nuevo usuario municipal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.usuarios.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="id_rol" class="form-label">rol del usuario</label>
                            <select name="id_rol" id="id_rol" class="form-select @error('id_rol') is-invalid @enderror"
                                required>
                                <option value="" selected disabled>selecciona un rol</option>
                                @foreach($roles as $rol)
                                <option value="{{ $rol->id_rol }}" {{ old('id_rol')==$rol->id_rol ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">asigne el cargo administrativo u operativo</small>
                            @error('id_rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- selector de punto verde, visible solo para operadores (rol 3) --}}
                        <div class="mb-3" id="campo-punto-verde" style="display: none;">
                            <label for="id_punto_verde" class="form-label">punto verde asignado</label>
                            <select name="id_punto_verde" id="id_punto_verde"
                                class="form-select @error('id_punto_verde') is-invalid @enderror">
                                <option value="">sin asignación</option>
                                @foreach($puntosVerdes as $pv)
                                <option value="{{ $pv->id_punto_verde }}" {{ old('id_punto_verde')==$pv->id_punto_verde
                                    ? 'selected' : '' }}>
                                    {{ $pv->nombre }} &mdash; {{ $pv->direccion }}
                                </option>
                                @endforeach
                            </select>
                            <small class="text-muted">punto verde que operará este usuario</small>
                            @error('id_punto_verde')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">nombre completo</label>
                            <input type="text" name="nombre" id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                                required>
                            @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label">correo electrónico</label>
                            <input type="email" name="correo" id="correo"
                                class="form-control @error('correo') is-invalid @enderror" value="{{ old('correo') }}"
                                required>
                            <small class="text-muted">correo institucional del empleado municipal</small>
                            @error('correo')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">teléfono (opcional)</label>
                            <input type="text" name="telefono" id="telefono"
                                class="form-control @error('telefono') is-invalid @enderror"
                                value="{{ old('telefono') }}">
                            @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">contraseña</label>
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" required>
                            <small class="text-muted">mínimo 8 caracteres</small>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">confirmar contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary text-uppercase fw-bold">registrar
                                usuario</button>
                            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-light">cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // muestra el selector de punto verde solo cuando se elige el rol 3 (operador)
    document.getElementById('id_rol').addEventListener('change', function () {
        const campoPV = document.getElementById('campo-punto-verde');
        campoPV.style.display = this.value == '3' ? 'block' : 'none';
    });

    // si hay error de validación y se eligió rol 3, mantener visible el campo
    document.addEventListener('DOMContentLoaded', function () {
        const rolSelect = document.getElementById('id_rol');
        if (rolSelect.value == '3') {
            document.getElementById('campo-punto-verde').style.display = 'block';
        }
    });
</script>
@endsection