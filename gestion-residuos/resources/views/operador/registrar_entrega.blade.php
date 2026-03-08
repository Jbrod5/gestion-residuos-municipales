@extends('layouts.operator')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i>Registro de Material</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('operador.entrega.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="id_material" class="form-label fw-bold small text-uppercase">Tipo de Residuo
                            municipal</label>
                        <select name="id_material" id="id_material"
                            class="form-select @error('id_material') is-invalid @enderror" required>
                            <option value="" selected disabled>Seleccione el material recibido</option>
                            @foreach($materiales as $material)
                            <option value="{{ $material->id_material }}">
                                {{ $material->nombre }}
                            </option>
                            @endforeach
                        </select>
                        @error('id_material') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cantidad_kg" class="form-label fw-bold small text-uppercase">Cantidad Recibida (KG)
                            municipal</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="cantidad_kg" id="cantidad_kg"
                                class="form-control @error('cantidad_kg') is-invalid @enderror" placeholder="0.00"
                                required>
                            <span class="input-group-text bg-light">KILOGRAMOS</span>
                        </div>
                        @error('cantidad_kg') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="ciudadano" class="form-label fw-bold small text-uppercase">Nombre del Ciudadano o
                            Notas municipal</label>
                        <textarea name="observaciones" id="ciudadano" class="form-control" rows="2"></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm">
                            <i class="bi bi-save me-2"></i>GUARDAR REGISTRO
                        </button>
                        <a href="{{ route('operador.dashboard') }}"
                            class="btn btn-outline-secondary py-2 border-0">Regresar al Panel Principal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection