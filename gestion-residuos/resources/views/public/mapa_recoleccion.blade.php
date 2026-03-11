@extends('layouts.publico')

@section('title', 'Mapa de Recolección - XelaLimpia')

@push('styles')
<style>
    #mapa-rutas { height: 600px; border-radius: 8px; }
    .list-group-item.active { background-color: #1a4731; border-color: #1a4731; }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold text-success">
                <i class="bi bi-map me-2"></i>
                Mapa de Rutas de Recolección
            </h2>
            <p class="text-muted">Consulta los horarios y recorridos de recolección en tu colonia</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pin-map me-2"></i>Recorridos disponibles
                </div>
                <div class="card-body p-1">
                    <div id="mapa-rutas"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-list-ul me-2"></i>Rutas disponibles
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" id="lista-rutas" style="max-height: 500px; overflow-y: auto;"></div>
                </div>
                <div class="card-footer text-muted small bg-light">
                    <i class="bi bi-info-circle me-1"></i>
                    Haz clic en una ruta para ver su recorrido
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapa = L.map('mapa-rutas').setView([14.84, -91.52], 13)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa)

    let capaSeleccionada = null
    const lista = document.getElementById('lista-rutas')

    fetch('{{ route('publico.api.rutas') }}')
        .then(r => r.json())
        .then(rutas => {
            rutas.forEach(ruta => {
                const item = document.createElement('a')
                item.className = 'list-group-item list-group-item-action'
                item.href = '#'
                item.innerHTML = `
                    <div class="d-flex w-100 justify-content-between">
                        <strong class="text-success">${ruta.nombre}</strong>
                    </div>
                    <small class="text-muted d-block">${ruta.zona ?? 'Zona sin nombre'}</small>
                    <small class="text-secondary d-block mt-1">
                        <i class="bi bi-clock me-1"></i>
                        ${ruta.dias.map(d => `${d.nombre} ${d.hora_inicio}-${d.hora_fin}`).join(', ')}
                    </small>
                `
                item.addEventListener('click', (e) => {
                    e.preventDefault()
                    
                    // Quitar active de todos
                    document.querySelectorAll('.list-group-item').forEach(el => {
                        el.classList.remove('active', 'text-white')
                    })
                    
                    // Activar este
                    item.classList.add('active', 'text-white')
                    
                    if (capaSeleccionada) {
                        mapa.removeLayer(capaSeleccionada)
                    }
                    
                    const coords = ruta.trayectoria
                    if (!coords || coords.length === 0) return
                    
                    capaSeleccionada = L.polyline(coords, {
                        color: '#1a4731',
                        weight: 5,
                        opacity: 0.8
                    }).addTo(mapa)
                    
                    mapa.fitBounds(capaSeleccionada.getBounds())
                    
                    const medio = coords[Math.floor(coords.length / 2)]
                    L.popup()
                        .setLatLng(medio)
                        .setContent(`
                            <div>
                                <strong class="text-success">${ruta.nombre}</strong><br>
                                <small>Zona: ${ruta.zona ?? 'N/D'}</small><br>
                                <small class="text-muted">Días y horarios:</small><br>
                                ${ruta.dias.map(d => `<small>• ${d.nombre} ${d.hora_inicio}-${d.hora_fin}</small><br>`).join('')}
                            </div>
                        `)
                        .openOn(mapa)
                })
                lista.appendChild(item)
            })
        })
})
</script>
@endpush