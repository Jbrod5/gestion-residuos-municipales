<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'XelaLimpia') - Gestión de Residuos</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>

<body class="bg-light" style="min-height: 100vh;">
    <!-- Navbar público con fondo blanco -->
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="/">
                <i class="bi bi-leaf-fill me-2 text-success"></i>
                <span class="text-dark">XELA<span class="text-success">LIMPIA</span></span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#publicNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="publicNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publico.mapa') ? 'active fw-bold text-success' : 'text-dark' }}" 
                           href="{{ route('publico.mapa') }}">
                           <i class="bi bi-map me-1"></i>Mapa de Recolección
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publico.puntos') ? 'active fw-bold text-success' : 'text-dark' }}" 
                           href="{{ route('publico.puntos') }}">
                           <i class="bi bi-recycle me-1"></i>Puntos Verdes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('publico.como-reciclar') ? 'active fw-bold text-success' : 'text-dark' }}" 
                           href="#">
                           <i class="bi bi-question-circle me-1"></i>¿Cómo reciclar?
                        </a>
                    </li>
                </ul>

                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-success me-2 btn-sm fw-bold border-2">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-sm fw-bold">
                        <i class="bi bi-person-plus me-1"></i> Registrarse
                    </a>
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