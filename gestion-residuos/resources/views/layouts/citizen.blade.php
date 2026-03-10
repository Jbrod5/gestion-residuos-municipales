<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Ciudadano') - Gestión de Residuos</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body class="bg-light" style="min-height: 100vh;">
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top py-2" style="background-color: #1a4731;">
    <div class="container">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('ciudadano.hub') }}">
            <i class="bi bi-leaf-fill me-2 text-info"></i>
            <span>XELA<span class="text-info">LIMPIA</span></span>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#citizenNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="citizenNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ciudadano.hub') ? 'active fw-bold' : '' }}" 
                       href="{{ route('ciudadano.hub') }}">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ciudadano.mapa') ? 'active fw-bold' : '' }}" 
                       href="{{ route('ciudadano.mapa') }}">Mapa de Recolección</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ciudadano.denuncias.create') ? 'active fw-bold' : '' }}" 
                       href="{{ route('ciudadano.denuncias.create') }}">Reportar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('ciudadano.denuncias.index') ? 'active fw-bold' : '' }}" 
                       href="{{ route('ciudadano.denuncias.index') }}">Mis Denuncias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('puntos-verdes') ? 'active fw-bold' : '' }}" 
                       href="{{ route('puntos-verdes') }}">Puntos Verdes</a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <div class="px-3 py-1 me-3 border-end border-white border-opacity-25 d-none d-md-block">
                    <span class="text-white-50 small">Hola,</span>
                    <span class="text-white small fw-bold ms-1">{{ auth()->user()->nombre }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-outline-info btn-sm fw-bold border-2">
                        <i class="bi bi-box-arrow-right me-1"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

    <main class="container py-5">
        @yield('content')
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>