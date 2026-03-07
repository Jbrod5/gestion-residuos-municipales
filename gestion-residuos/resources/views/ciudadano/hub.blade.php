@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <h1 class="mb-4">panel del ciudadano</h1>
            <p class="lead mb-5">bienvenido al sistema de gestión de residuos, ¿qué deseas hacer hoy?</p>
            
            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                <a href="{{ route('ciudadano.denuncias.index') }}" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-list-stars"></i> ver mis denuncias
                </a>
                <a href="{{ route('ciudadano.denuncias.create') }}" class="btn btn-success btn-lg px-4">
                    <i class="bi bi-plus-circle"></i> nueva denuncia
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
