@extends('layouts.admin')

@section('title', 'Gestión de Zonas')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 400px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-bottom: 20px;
    }
    .zona-item {
        cursor: pointer;
        transition: all 0.2s;
    }
    .zona-item:hover {
        background-color: rgba(255, 193, 7, 0.1);
        transform: translateX(5px);
    }
    .zona-item.active {
        background-color: rgba(255, 193, 7, 0.2);
        border-left: 4px solid #ffc107;
    }
    .coordenadas-info {
        font-family: monospace;
        background: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-geo-alt-fill text-warning me-2"></i>
                Gestión de Zonas
            </h2>
            <p class="text-muted">Administra las zonas/colonias del municipio</p>
        </div>
    </div>

    <!-- Mensajes Flash -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Mapa -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white">
            <i class="bi bi-map me-2"></i>Visualización de Zonas
        </div>
        <div class="card-body p-2">
            <div id="map"></div>
        </div>
    </div>

    <!-- Dos columnas: Zonas y Tipos de Zona -->
    <div class="row">
        <!-- Columna de Zonas -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-list-ul me-2"></i>Zonas Registradas
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevaZona">
                        <i class="bi bi-plus-circle me-1"></i>Nueva Zona
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Coordenadas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($zonas as $zona)
                                <tr class="zona-item" data-id="{{ $zona->id_zona }}" data-lat="{{ $zona->latitud }}" data-lng="{{ $zona->longitud }}" data-nombre="{{ $zona->nombre }}">
                                    <td class="fw-bold">#{{ $zona->id_zona }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $zona->nombre }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $zona->tipoZona->nombre }}</span>
                                    </td>
                                    <td>
                                        @if($zona->latitud && $zona->longitud)
                                            <span class="coordenadas-info">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                                {{ number_format($zona->latitud, 4) }}, {{ number_format($zona->longitud, 4) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Sin coordenadas</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-outline-info" onclick="centrarMapa({{ $zona->id_zona }})" title="Ver en mapa">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <form action="{{ route('admin.zonas.destroy', $zona->id_zona) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar esta zona?')" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-geo-alt fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted mb-0">No hay zonas registradas</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna de Tipos de Zona -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-tags me-2"></i>Tipos de Zona
                    </div>
                    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoTipo">
                        <i class="bi bi-plus-circle me-1"></i>Nuevo Tipo
                    </button>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($tiposZona as $tipo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold">{{ $tipo->nombre }}</span>
                                @if($tipo->descripcion)
                                    <br><small class="text-muted">{{ $tipo->descripcion }}</small>
                                @endif
                            </div>
                            <span class="badge bg-secondary">{{ $zonas->where('id_tipo_zona', $tipo->id_tipo_zona)->count() }} zonas</span>
                        </li>
                        @empty
                        <li class="list-group-item text-center py-4">
                            <i class="bi bi-tag fa-3x text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-0">No hay tipos de zona</p>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Zona -->
<div class="modal fade" id="modalNuevaZona" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Nueva Zona
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.zonas.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Nombre de la Zona</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ej: Zona 1, Centro Histórico..." required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tipo de Zona</label>
                            <select name="id_tipo_zona" class="form-select" required>
                                <option value="">Seleccionar tipo</option>
                                @foreach($tiposZona as $tipo)
                                    <option value="{{ $tipo->id_tipo_zona }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ubicación en el mapa</label>
                        <div id="modal-map" style="height: 300px; border-radius: 8px; border: 1px solid #dee2e6;"></div>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>
                            Haz clic en el mapa para marcar la ubicación de la zona
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Latitud</label>
                            <input type="text" name="latitud" id="latitud" class="form-control" readonly placeholder="Selecciona en el mapa">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Longitud</label>
                            <input type="text" name="longitud" id="longitud" class="form-control" readonly placeholder="Selecciona en el mapa">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="bi bi-save me-2"></i>Guardar Zona
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Nuevo Tipo de Zona -->
<div class="modal fade" id="modalNuevoTipo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-2"></i>Nuevo Tipo de Zona
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.zonas.tipos-zona.store') }}" method="POST">                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre del Tipo</label>
                        <input type="text" name="nombre" class="form-control" placeholder="Ej: Residencial, Comercial, Industrial..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3" placeholder="Describe este tipo de zona..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning fw-bold">
                        <i class="bi bi-save me-2"></i>Guardar Tipo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Variables globales
    let map, modalMap, modalMarker;
    
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializar mapa principal
        initMapaPrincipal();
        
        // Inicializar mapa del modal cuando se abre el modal
        const modalNuevaZona = document.getElementById('modalNuevaZona');
        if (modalNuevaZona) {
            modalNuevaZona.addEventListener('shown.bs.modal', function() {
                // Pequeño retraso para asegurar que el modal está completamente visible
                setTimeout(initMapaModal, 100);
            });
        }
        
        // Hacer que las filas de la tabla sean clickeables
        document.querySelectorAll('.zona-item').forEach(row => {
            row.addEventListener('click', function(e) {
                // Evitar si el click fue en un botón
                if (e.target.closest('button') || e.target.closest('form')) return;
                
                const lat = this.dataset.lat;
                const lng = this.dataset.lng;
                const nombre = this.dataset.nombre;
                
                if (lat && lng) {
                    centrarMapaEn(this.dataset.id);
                    
                    // Quitar clase active de todas las filas
                    document.querySelectorAll('.zona-item').forEach(r => r.classList.remove('active'));
                    
                    // Agregar clase active a esta fila
                    this.classList.add('active');
                }
            });
        });
    });
    
    function initMapaPrincipal() {
        // Centro por defecto: Quetzaltenango
        map = L.map('map').setView([14.84, -91.52], 12);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);
        
        // Agrupar marcadores por tipo de zona (colores diferentes)
        const markers = [];
        
        @foreach($zonas as $zona)
            @if($zona->latitud && $zona->longitud)
                (function() {
                    // Color según tipo de zona (puedes personalizar)
                    let color = '#ffc107'; // Amarillo por defecto
                    @if($zona->tipoZona->nombre == 'Residencial')
                        color = '#28a745'; // Verde
                    @elseif($zona->tipoZona->nombre == 'Comercial')
                        color = '#17a2b8'; // Azul
                    @elseif($zona->tipoZona->nombre == 'Industrial')
                        color = '#dc3545'; // Rojo
                    @endif
                    
                    const marker = L.circleMarker([{{ $zona->latitud }}, {{ $zona->longitud }}], {
                        radius: 8,
                        fillColor: color,
                        color: '#000',
                        weight: 1,
                        opacity: 1,
                        fillOpacity: 0.8
                    }).addTo(map);
                    
                    marker.bindPopup(`
                        <strong>{{ $zona->nombre }}</strong><br>
                        Tipo: {{ $zona->tipoZona->nombre }}<br>
                        <small>{{ number_format($zona->latitud, 4) }}, {{ number_format($zona->longitud, 4) }}</small>
                    `);
                    
                    markers.push(marker);
                })();
            @endif
        @endforeach
        
        // Si hay marcadores, ajustar el mapa para mostrarlos todos
        if (markers.length > 0) {
            const group = L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.2));
        }
    }
    
    function initMapaModal() {
        const modalMapContainer = document.getElementById('modal-map');
        if (!modalMapContainer) return;
        
        // Si ya existe un mapa en el modal, destruirlo primero
        if (modalMap) {
            modalMap.remove();
        }
        
        // Crear nuevo mapa
        modalMap = L.map('modal-map').setView([14.84, -91.52], 13);
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(modalMap);
        
        // Forzar el recalculo del tamaño del mapa
        setTimeout(() => {
            modalMap.invalidateSize();
        }, 200);
        
        // Al hacer clic en el mapa del modal, colocar un marcador
        modalMap.on('click', function(e) {
            const { lat, lng } = e.latlng;
            
            // Eliminar marcador anterior si existe
            if (modalMarker) {
                modalMap.removeLayer(modalMarker);
            }
            
            // Crear nuevo marcador
            modalMarker = L.marker([lat, lng]).addTo(modalMap);
            
            // Actualizar campos
            document.getElementById('latitud').value = lat.toFixed(6);
            document.getElementById('longitud').value = lng.toFixed(6);
        });
    }
    
    function centrarMapa(id) {
        fetch(`/admin/zonas/api/${id}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    centrarMapaEnCoordenadas(data.zona.latitud, data.zona.longitud, data.zona.nombre);
                }
            });
    }
    
    function centrarMapaEnCoordenadas(lat, lng, nombre) {
        map.setView([lat, lng], 15);
        
        // Buscar y resaltar el marcador correspondiente
        map.eachLayer(layer => {
            if (layer instanceof L.CircleMarker) {
                const layerLatLng = layer.getLatLng();
                if (Math.abs(layerLatLng.lat - lat) < 0.001 && Math.abs(layerLatLng.lng - lng) < 0.001) {
                    layer.setStyle({
                        radius: 12,
                        fillOpacity: 1,
                        color: '#000',
                        weight: 2
                    });
                    
                    layer.openPopup();
                    
                    // Restaurar después de 2 segundos
                    setTimeout(() => {
                        layer.setStyle({
                            radius: 8,
                            fillOpacity: 0.8,
                            weight: 1
                        });
                    }, 2000);
                }
            }
        });
    }
    
    // Función llamada desde los botones "Ver en mapa"
    window.centrarMapa = function(id) {
        centrarMapa(id);
    };
</script>
@endpush