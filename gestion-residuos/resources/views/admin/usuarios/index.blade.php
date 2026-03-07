@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>gestión de usuarios municipales</h2>
        <a href="{{ route('admin.usuarios.create') }}" class="btn btn-primary">nuevo usuario</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>nombre</th>
                            <th>correo</th>
                            <th>rol municipal</th>
                            <th>estado</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>#{{ $usuario->id_usuario }}</td>
                                <td>{{ $usuario->nombre }}</td>
                                <td>{{ $usuario->correo }}</td>
                                <td>
                                    <span class="badge bg-info text-dark">{{ $usuario->rol->nombre }}</span>
                                </td>
                                <td>
                                    @if($usuario->activo)
                                        <span class="badge bg-success">ACTIVO</span>
                                    @else
                                        <span class="badge bg-danger">INACTIVO</span>
                                    @endif
                                </td>
                                <td>
                                    @if($usuario->activo && $usuario->id_usuario !== Auth::id())
                                        <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" method="POST" onsubmit="return confirm('¿seguro que quieres desactivar a este compañero municipal?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">desactivar</button>
                                        </form>
                                    @elseif($usuario->id_usuario === Auth::id())
                                        <span class="text-muted small">eres tú</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
