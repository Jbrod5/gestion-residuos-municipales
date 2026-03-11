@extends('layouts.publico')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 500px;">
        <div class="card-body p-5">
            <h3 class="text-center mb-4 text-success fw-bold">Registro de Ciudadano</h3>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autofocus >
                </div>

                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input id="correo" type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo') }}" required >
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono (Opcional)</label>
                    <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="{{ old('telefono') }}" >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-success btn-lg">Registrarse</button>
                </div>
                
                <div class="text-center mt-3">
                    <span class="text-muted">¿Ya tienes cuenta?</span> <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Inicia Sesión</a>
                </div>
            </form>

            <hr class="my-4">
            <div class="text-center">
                <p class="text-muted mb-2">¿Solo quieres consultar?</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('publico.mapa') }}" class="btn btn-outline-success me-md-2">
                        <i class="bi bi-map me-1"></i>Mapa de rutas
                    </a>
                    <a href="{{ route('publico.puntos') }}" class="btn btn-outline-info">
                        <i class="bi bi-recycle me-1"></i>Puntos verdes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
