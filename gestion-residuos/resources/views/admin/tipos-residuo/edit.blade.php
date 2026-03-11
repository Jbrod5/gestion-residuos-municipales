@extends('layouts.admin')

@section('title', 'Editar Tipo de Residuo')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-warning py-3">
                    <h5 class="mb-0 text-white fw-bold">
                        <i class="fas fa-edit me-2"></i>
                        Editar Tipo de Residuo: {{ $tipo->nombre }}
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.tipos-residuo.update', $tipo->id_tipo_residuo) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        @include('admin.tipos-residuo._form')
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.tipos-residuo.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save me-2"></i>Actualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection