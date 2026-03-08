@extends('layouts.coordinator')

@section('title', 'Nueva Asignación de Ruta')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header bg-success py-3">
                    <h5 class="mb-0 text-white fw-bold">📅 Programación de Recolección</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('coordinator.asignaciones.store') }}" method="POST" id="formAsignacion">
                        @csrf
                        <div class="row g-4">
                            <!-- Selección de Ruta y Fecha -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">1. Seleccionar Ruta Municipal</label>
                                <select name="id_ruta" id="id_ruta" class="form-select form-select-lg border-2" required>
                                    <option value="">-- Elige una ruta --</option>
                                    @foreach($rutas as $ruta)
                                        <option value="{{ $ruta->id_ruta }}" 
                                                data-peso="{{ $ruta->basura_total_estimada / 1000 }}"
                                                data-horarios="{{ json_encode($ruta->dias->map(function($d) {
                                                    return [
                                                        'nombre' => $d->nombre,
                                                        'inicio' => \Carbon\Carbon::parse($d->pivot->hora_inicio)->format('H:i'),
                                                        'fin' => \Carbon\Carbon::parse($d->pivot->hora_fin)->format('H:i')
                                                    ];
                                                })) }}">
                                            {{ $ruta->nombre }} ({{ number_format($ruta->basura_total_estimada / 1000, 2) }} t)
                                        </option>
                                    @endforeach
                                </select>
                                <div id="info-horario" class="mt-3 d-none">
                                    <h6 class="small fw-bold text-muted text-uppercase mb-2">Programación de la Ruta:</h6>
                                    <div id="horarios-lista" class="d-flex flex-wrap gap-2">
                                        <!-- Se llena vía JS -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">2. Fecha de Recolección</label>
                                <input type="date" name="fecha" id="fecha" class="form-control form-control-lg border-2" required min="{{ date('Y-m-d') }}">
                                <div id="warning-fecha" class="alert alert-warning mt-2 d-none">
                                    <i class="fas fa-exclamation-triangle me-2"></i><strong>Atención:</strong> Esta fecha no coincide con los días programados de la ruta. Se registrará como recolección extraordinaria.
                                </div>
                            </div>

                            <!-- Selección de Camión y Conductor -->
                            <div class="col-md-6">
                                <label class="form-label fw-bold">3. Camión Disponible</label>
                                <select name="id_camion" id="id_camion" class="form-select form-select-lg border-2" required disabled>
                                    <option value="">-- Primero elige ruta y fecha --</option>
                                </select>
                                <div id="loading-camiones" class="text-muted small mt-1 d-none">
                                    <span class="spinner-border spinner-border-sm me-2"></span>Buscando camiones aptos...
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">4. Conductor Asignado</label>
                                <select name="id_conductor" class="form-select form-select-lg border-2">
                                    <option value="">-- Seleccionar Conductor (Opcional) --</option>
                                    @foreach($conductores as $conductor)
                                        <option value="{{ $conductor->id_usuario }}">{{ $conductor->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">5. Cuadrilla Municipal</label>
                                <select name="id_cuadrilla" class="form-select form-select-lg border-2">
                                    <option value="">-- Seleccionar Cuadrilla (Opcional) --</option>
                                    @foreach($cuadrillas as $cuadrilla)
                                        <option value="{{ $cuadrilla->id_cuadrilla }}">{{ $cuadrilla->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Notas -->
                            <div class="col-12">
                                <label class="form-label fw-bold">Notas de la Asignación</label>
                                <textarea name="notas_incidencias" class="form-control" rows="2" placeholder="Ej. Ruta prioritaria por acumulación municipal"></textarea>
                            </div>

                            <div class="col-12 text-end mt-4">
                                <a href="{{ route('coordinator.asignaciones.index') }}" class="btn btn-light px-4 me-2 border">Cancelar</a>
                                <button type="submit" class="btn btn-success px-5 fw-bold" id="btnSubmit">
                                    Confirmar Asignación
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectRuta = document.getElementById('id_ruta');
    const inputFecha = document.getElementById('fecha');
    const selectCamion = document.getElementById('id_camion');
    const warningFecha = document.getElementById('warning-fecha');
    const loadingCamiones = document.getElementById('loading-camiones');
    const infoHorario = document.getElementById('info-horario');
    const listaHorarios = document.getElementById('horarios-lista');

    function checkDisponibilidad() {
        const selectedOption = selectRuta.options[selectRuta.selectedIndex];
        const idRuta = selectRuta.value;
        const fecha = inputFecha.value;

        // Mostrar Horarios de la Ruta
        if (idRuta && selectedOption.dataset.horarios) {
            const horarios = JSON.parse(selectedOption.dataset.horarios);
            listaHorarios.innerHTML = '';
            horarios.forEach(h => {
                listaHorarios.innerHTML += `
                    <span class="badge bg-white text-success border border-success px-3 py-2 rounded-pill">
                        <i class="fas fa-clock me-1"></i> ${h.nombre}: ${h.inicio} - ${h.fin}
                    </span>`;
            });
            infoHorario.classList.remove('d-none');
        } else {
            infoHorario.classList.add('d-none');
        }

        if (idRuta && fecha) {
            selectCamion.disabled = true;
            loadingCamiones.classList.remove('d-none');
            
            fetch(`{{ route('coordinator.api.disponibilidad') }}?id_ruta=${idRuta}&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                    loadingCamiones.classList.add('d-none');
                    selectCamion.innerHTML = '<option value="">-- Seleccionar Camión --</option>';
                    
                    if (data.camiones.length > 0) {
                        data.camiones.forEach(camion => {
                            selectCamion.innerHTML += `<option value="${camion.id_camion}">
                                ${camion.placa} - Capacidad: ${camion.capacidad_toneladas}t
                            </option>`;
                        });
                        selectCamion.disabled = false;
                    } else {
                        selectCamion.innerHTML = '<option value="">No hay camiones aptos/disponibles</option>';
                    }

                    if (data.es_programada) {
                        warningFecha.classList.add('d-none');
                    } else {
                        warningFecha.classList.remove('d-none');
                    }
                })
                .catch(err => {
                    console.error('Error fetching disponibilidad:', err);
                    loadingCamiones.classList.add('d-none');
                });
        }
    }

    [selectRuta, inputFecha].forEach(el => el.addEventListener('change', checkDisponibilidad));
});
</script>
@endsection
