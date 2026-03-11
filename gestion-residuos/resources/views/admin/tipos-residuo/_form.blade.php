<div class="mb-3">
    <label for="nombre" class="form-label fw-bold">
        Nombre del Tipo <span class="text-danger">*</span>
    </label>
    <input type="text" 
           class="form-control form-control-lg @error('nombre') is-invalid @enderror" 
           id="nombre" 
           name="nombre" 
           value="{{ old('nombre', $tipo->nombre ?? '') }}"
           placeholder="Ej: Orgánico, Inorgánico, Plástico, Vidrio..."
           required>
    @error('nombre')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <small class="text-muted">Nombre único para identificar el tipo de residuo</small>
</div>

<div class="mb-3">
    <label for="descripcion" class="form-label fw-bold">Descripción</label>
    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
              id="descripcion" 
              name="descripcion" 
              rows="4"
              placeholder="Describe qué tipo de residuos incluye esta categoría...">{{ old('descripcion', $tipo->descripcion ?? '') }}</textarea>
    @error('descripcion')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>