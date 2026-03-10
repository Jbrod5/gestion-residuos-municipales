@extends('layouts.citizen') 

@section('title', 'Mapa de recolección')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header">Mapa de rutas de recolección en Xela</div>
                <div class="card-body p-0">
                    <div id="mapa-rutas" style="height: 600px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-header">Rutas disponibles</div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush" id="lista-rutas"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapa = L.map('mapa-rutas').setView([14.84, -91.52], 13)

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(mapa)

    let capaSeleccionada = null

    fetch('{{ route('ciudadano.api.rutas') }}')
        .then(r => r.json())
        .then(rutas => {
            const lista = document.getElementById('lista-rutas')
            rutas.forEach(ruta => {
                const li = document.createElement('li')
                li.className = 'list-group-item list-group-item-action'
                li.style.cursor = 'pointer'
                li.innerHTML = `<strong>${ruta.nombre}</strong><br>
                    <small>${ruta.zona ?? 'Zona sin nombre'}</small><br>
                    <small>${ruta.dias.map(d => d.nombre + ' ' + d.hora_inicio + '-' + d.hora_fin).join(', ')}</small>`
                li.addEventListener('click', () => {
                    if (capaSeleccionada) {
                        mapa.removeLayer(capaSeleccionada)
                    }
                    const coords = ruta.trayectoria
                    if (!coords || coords.length === 0) return
                    capaSeleccionada = L.polyline(coords, {color: 'green'}).addTo(mapa)
                    mapa.fitBounds(capaSeleccionada.getBounds())
                    const medio = coords[Math.floor(coords.length / 2)]
                    L.popup()
                        .setLatLng(medio)
                        .setContent(`
                            <div>
                                <strong>${ruta.nombre}</strong><br>
                                Zona: ${ruta.zona ?? 'N/D'}<br>
                                Días y horarios:<br>
                                ${ruta.dias.map(d => '- ' + d.nombre + ' ' + d.hora_inicio + '-' + d.hora_fin).join('<br>')}
                            </div>
                        `)
                        .openOn(mapa)
                })
                lista.appendChild(li)
            })
        })
})
</script>
@endsection

