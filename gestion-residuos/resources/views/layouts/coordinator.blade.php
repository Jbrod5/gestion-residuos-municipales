<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coordinador') - XelaLimpia</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>

<body class="bg-light" style="min-height: 100vh;">
    <!-- Navbar COORDINADOR con fondo AMARILLO -->
    <nav class="navbar navbar-expand-lg bg-warning shadow-sm sticky-top py-3" data-bs-theme="light">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('coordinator.dashboard') }}">
                <i class="bi bi-map-fill me-2 text-dark"></i>
                <span class="text-dark">XELA<span class="text-dark fw-bolder">LIMPIA</span></span>
                <span class="badge bg-dark text-warning ms-2">COORDINADOR</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#coordinatorNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="coordinatorNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.dashboard') ? 'active fw-bold text-dark' : 'text-dark' }}" 
                           href="{{ route('coordinator.dashboard') }}">
                           <i class="bi bi-speedometer2 me-1"></i>Panel de Control
                        </a>
                    </li>

                    <!-- Gestión de Rutas -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('coordinator.rutas.*') || request()->routeIs('coordinator.asignaciones.*') ? 'active fw-bold text-dark' : 'text-dark' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                           <i class="bi bi-signpost-split me-1"></i>Rutas
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('coordinator.rutas.*') ? 'active' : '' }}" href="{{ route('coordinator.rutas.index') }}">Gestionar Rutas</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('coordinator.rutas.create') ? 'active' : '' }}" href="{{ route('coordinator.rutas.create') }}">Nueva Ruta</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item {{ request()->routeIs('coordinator.asignaciones.*') ? 'active' : '' }}" href="{{ route('coordinator.asignaciones.index') }}">Asignaciones</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('coordinator.asignaciones.create') ? 'active' : '' }}" href="{{ route('coordinator.asignaciones.create') }}">Nueva Asignación</a></li>
                        </ul>
                    </li>

                    <!-- Denuncias -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.denuncias.*') ? 'active fw-bold text-dark' : 'text-dark' }}" 
                           href="{{ route('coordinator.denuncias.index') }}">
                           <i class="bi bi-exclamation-triangle me-1"></i>Gestión de Denuncias
                        </a>
                    </li>

                    <!-- Solicitudes de Vaciado -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.solicitudes.*') ? 'active fw-bold text-dark' : 'text-dark' }}" 
                           href="{{ route('coordinator.solicitudes.index') }}">
                           <i class="bi bi-droplet me-1"></i>Solicitudes de Vaciado
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="me-3 text-end">
                        <small class="text-dark opacity-75 d-block">Coordinador de Rutas</small>
                        <span class="text-dark fw-bold">
                            <i class="bi bi-person-check-fill text-dark me-1"></i>
                            {{ auth()->user()->nombre }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-dark btn-sm fw-bold">
                            <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @stack('scripts')
</body>
</html>