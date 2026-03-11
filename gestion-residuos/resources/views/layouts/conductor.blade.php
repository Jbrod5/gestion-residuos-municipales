<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conductor') - XelaLIMPIA</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    @stack('styles')
</head>

<body class="bg-light" style="min-height: 100vh;">
    <!-- Navbar específico para conductor con estilo XelaLIMPIA -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top py-2" style="background-color: #1a4731;">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('conductor.dashboard') }}">
                <i class="bi bi-truck me-2 text-warning"></i>
                <span>XELA<span class="text-warning">LIMPIA</span></span>
                <span class="badge bg-warning text-dark ms-3 px-3 py-2 rounded-pill">
                    <i class="bi bi-person-workspace me-1"></i>CONDUCTOR
                </span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#conductorNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="conductorNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('conductor.dashboard') ? 'active fw-bold text-warning' : '' }}" 
                           href="{{ route('conductor.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('conductor.asignaciones.index') ? 'active fw-bold text-warning' : '' }}" 
                           href="{{ route('conductor.asignaciones.index') }}">
                            <i class="bi bi-clock-history me-1"></i> Mi Historial
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="px-3 py-1 me-3 border-end border-white border-opacity-25 d-none d-md-block">
                        <span class="text-white-50 small">Conductor:</span>
                        <span class="text-white small fw-bold ms-1">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->nombre }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm fw-bold border-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    @stack('scripts')
</body>

</html>