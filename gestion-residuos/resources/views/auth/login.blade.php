@extends('layouts.publico')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-sm border-0" style="width: 100%; max-width: 400px;">
        <div class="card-body p-5">
            <h3 class="text-center mb-4 text-primary fw-bold">Bienvenido</h3>

            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input id="correo" type="email" class="form-control @error('correo') is-invalid @enderror" name="correo" value="{{ old('correo') }}" required autofocus>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                </div>

                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
                </div>
                
                <div class="text-center mt-3">
                    <span class="text-muted">¿No tienes cuenta?</span> <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Regístrate</a>
                </div>
            </form>

            <!-- Enlaces de puntos y rutas -->
            <hr class="my-4">
            <div class="text-center">
                <p class="text-muted mb-2">¿Quieres consultar sin iniciar sesión?</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('publico.mapa') }}" class="btn btn-outline-success me-md-2">
                        <i class="bi bi-map me-1"></i>Ver rutas
                    </a>
                    <a href="{{ route('publico.puntos') }}" class="btn btn-outline-info">
                        <i class="bi bi-recycle me-1"></i>Ver puntos verdes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
