@extends('layouts.citizen')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>mis denuncias</h2>
        <a href="{{ route('ciudadano.denuncias.create') }}" class="btn btn-success">
            nueva denuncia
        </a>
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
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>ubicación</th>
                            <th>estado</th>
                            <th>fecha</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($denuncias as $denuncia)
                            <tr>
                                <td>#{{ $denuncia->id_denuncia }}</td>
                                <td>{{ $denuncia->tamano->nombre ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge @if($denuncia->estado->nombre == 'Pendiente') bg-warning @elseif($denuncia->estado->nombre == 'En Revisión') bg-info @else bg-success @endif">
                                        {{ $denuncia->estado->nombre }}
                                    </span>
                                </td>
                                <td>{{ $denuncia->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('ciudadano.denuncias.show', $denuncia->id_denuncia) }}" class="btn btn-sm btn-outline-primary">ver detalles</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">no tienes denuncias registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="{{ route('ciudadano.hub') }}" class="btn btn-secondary">volver al menú</a>
    </div>
</div>
@endsection
