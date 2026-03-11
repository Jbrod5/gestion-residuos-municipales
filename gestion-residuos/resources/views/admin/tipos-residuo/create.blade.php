@extends('layouts.admin')

@section('title', 'Nuevo Tipo de Residuo')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-success py-3">
                    <h5 class="mb-0 text-white fw-bold">
                        <i class="fas fa-plus-circle me-2"></i>
                        Nuevo Tipo de Residuo
                    </h5>
                </div>
                
                <div class="card-body p-4">
                    <form action="{{ route('admin.tipos-residuo.store') }}" method="POST">
                        @csrf
                        
                        @include('admin.tipos-residuo._form')
                        
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.tipos-residuo.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>Guardar Tipo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection