@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">reportar basurero clandestino</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('ciudadano.denuncias.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="id_tamano_denuncia" class="form-label">tamaño de la denuncia</label>
                            <select name="id_tamano_denuncia" id="id_tamano_denuncia" class="form-select @error('id_tamano_denuncia') is-invalid @enderror" required>
                                <option value="" selected disabled>selecciona un tamaño</option>
                                @foreach($tamanos as $tamano)
                                    <option value="{{ $tamano->id_tamano_denuncia }}" {{ old('id_tamano_denuncia') == $tamano->id_tamano_denuncia ? 'selected' : '' }}>
                                        {{ $tamano->nombre }} - {{ $tamano->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_tamano_denuncia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="latitud" class="form-label">latitud (opcional)</label>
                                <input type="number" step="any" name="latitud" id="latitud" class="form-control @error('latitud') is-invalid @enderror" value="{{ old('latitud') }}" placeholder="ej: 14.6349">
                                @error('latitud')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="longitud" class="form-label">longitud (opcional)</label>
                                <input type="number" step="any" name="longitud" id="longitud" class="form-control @error('longitud') is-invalid @enderror" value="{{ old('longitud') }}" placeholder="ej: -90.5069">
                                @error('longitud')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">descripción del problema</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="form-control @error('descripcion') is-invalid @enderror" required placeholder="danos mas detalles sobre la denuncia">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">tomar o subir foto (opcional)</label>
                            <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">ayúdanos a identificar el lugar con una imagen clara</div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('ciudadano.hub') }}" class="btn btn-outline-secondary">cancelar</a>
                            <button type="submit" class="btn btn-success px-5">enviar reporte</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
