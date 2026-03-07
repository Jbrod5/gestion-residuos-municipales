@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>gestión global de denuncias</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>ciudadano</th>
                            <th>tamaño</th>
                            <th>estado actual</th>
                            <th>fecha</th>
                            <th>cambiar estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($denuncias as $denuncia)
                            <tr>
                                <td>#{{ $denuncia->id_denuncia }}</td>
                                <td>{{ $denuncia->usuario->nombre }}</td>
                                <td>{{ $denuncia->tamano->nombre }}</td>
                                <td>
                                    <span class="badge @if($denuncia->estado->nombre == 'Pendiente') bg-warning @elseif($denuncia->estado->nombre == 'En Revisión') bg-info @else bg-success @endif">
                                        {{ $denuncia->estado->nombre }}
                                    </span>
                                </td>
                                <td>{{ $denuncia->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <form action="{{ route('admin.denuncias.update', $denuncia->id_denuncia) }}" method="POST" class="d-flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="id_estado_denuncia" class="form-select form-select-sm" required>
                                            @foreach($estados as $estado)
                                                <option value="{{ $estado->id_estado_denuncia }}" {{ $denuncia->id_estado_denuncia == $estado->id_estado_denuncia ? 'selected' : '' }}>
                                                    {{ $estado->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-outline-success">actualizar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">volver al dashboard</a>
    </div>
</div>
@endsection
