@extends('layouts.admin')

@section('title', 'Tipos de Residuo')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="fas fa-trash-alt text-success me-2"></i>
                Tipos de Residuo
            </h2>
            <p class="text-muted">Gestión de clasificaciones de residuos recolectados</p>
        </div>
        <a href="{{ route('admin.tipos-residuo.create') }}" class="btn btn-success">
            <i class="fas fa-plus-circle me-2"></i>Nuevo Tipo
        </a>
    </div>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tabla -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Rutas Asociadas</th>
                            <th>Fecha Creación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tipos as $tipo)
                        <tr>
                            <td class="fw-bold">#{{ $tipo->id_tipo_residuo }}</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success p-2">
                                    {{ $tipo->nombre }}
                                </span>
                            </td>
                            <td>{{ $tipo->descripcion ?? '—' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $tipo->rutas->count() }} rutas</span>
                            </td>
                            <td>
                                @if($tipo->created_at)
                                    {{ $tipo->created_at->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.tipos-residuo.show', $tipo->id_tipo_residuo) }}" 
                                       class="btn btn-sm btn-outline-info">
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.tipos-residuo.edit', $tipo->id_tipo_residuo) }}" 
                                       class="btn btn-sm btn-outline-warning">
                                        Editar
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            onclick="confirmarEliminacion({{ $tipo->id_tipo_residuo }}, '{{ $tipo->nombre }}')">
                                        Eliminar
                                    </button>
                                </div>

                                <!-- Formulario oculto para eliminar -->
                                <form id="delete-form-{{ $tipo->id_tipo_residuo }}" 
                                      action="{{ route('admin.tipos-residuo.destroy', $tipo->id_tipo_residuo) }}" 
                                      method="POST" 
                                      class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fas fa-trash-alt fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">No hay tipos de residuo registrados</h5>
                                <a href="{{ route('admin.tipos-residuo.create') }}" class="btn btn-success mt-2">
                                    Crear el primero
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($tipos, 'links'))
        <div class="card-footer bg-white">
            {{ $tipos->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="modalEliminar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirmar Eliminación
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de eliminar el tipo de residuo <strong id="tipo-nombre"></strong>?</p>
                <p class="text-danger small">
                    <i class="fas fa-info-circle me-1"></i>
                    Esta acción no se puede deshacer si el tipo no está siendo usado.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">
                    <i class="fas fa-trash me-2"></i>Sí, eliminar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmarEliminacion(id, nombre) {
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    document.getElementById('tipo-nombre').textContent = nombre;
    
    document.getElementById('btnConfirmarEliminar').onclick = function() {
        document.getElementById(`delete-form-${id}`).submit();
    };
    
    modal.show();
}
</script>
@endpush