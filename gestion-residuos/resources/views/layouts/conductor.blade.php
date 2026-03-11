<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Conductor') - XelaLimpia</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>

<body class="bg-light" style="min-height: 100vh;">
    <!-- Navbar CONDUCTOR con fondo AZUL MARINO (profesional, confiable, sólido) -->
    <nav class="navbar navbar-expand-lg" style="background-color: #0b3b5c; box-shadow: 0 4px 12px rgba(0,0,0,0.2);" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('conductor.dashboard') }}">
                <i class="bi bi-truck me-2 text-info"></i>
                <span class="text-white">XELA<span class="text-info">LIMPIA</span></span>
                <span class="badge bg-info text-dark ms-2">CONDUCTOR</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#conductorNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="conductorNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('conductor.dashboard') ? 'active fw-bold text-info' : 'text-white-50' }}" 
                           href="{{ route('conductor.dashboard') }}">
                           <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('conductor.asignaciones.index') ? 'active fw-bold text-info' : 'text-white-50' }}" 
                           href="{{ route('conductor.asignaciones.index') }}">
                           <i class="bi bi-clock-history me-1"></i>Mi Historial
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="me-3 text-end">
                        <small class="text-white-50 d-block">
                            <i class="bi bi-person-workspace me-1"></i>
                            Conductor
                        </small>
                        <span class="text-white fw-bold">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->nombre }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-info btn-sm fw-bold border-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            @if(session('success'))
            <div class="mb-4">
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #0b3b5c;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #0b3b5c;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html>