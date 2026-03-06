@extends('layouts.app')

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
        </div>
    </div>
</div>
@endsection
