<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ciudadano - Sistema Municipal de Gestión de Residuos</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f0f2f5;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 700;
        }

        .nav-link {
            font-weight: 500;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: #0d6efd !important;
            transform: translateY(-1px);
        }

        .main-container {
            padding-top: 2rem;
            padding-bottom: 5rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary" href="{{ route('ciudadano.hub') }}">
                <i class="bi bi-recycle me-2"></i>Gestión de Residuos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#citizenNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="citizenNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ciudadano.hub') ? 'active text-primary fw-bold' : '' }}" 
                           href="{{ route('ciudadano.hub') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ciudadano.denuncias.create') ? 'active text-primary fw-bold' : '' }}" 
                           href="{{ route('ciudadano.denuncias.create') }}">Reportar Basurero</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ciudadano.denuncias.index') ? 'active text-primary fw-bold' : '' }}" 
                           href="{{ route('ciudadano.denuncias.index') }}">Mis Denuncias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ciudadano.mapa') ? 'active text-primary fw-bold' : '' }}" 
                           href="{{ route('ciudadano.mapa') }}">Mapa de Recolección</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('ciudadano.puntos-verdes') ? 'active text-primary fw-bold' : '' }}" 
                           href="{{ route('ciudadano.puntos-verdes') }}">Puntos Verdes</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="text-muted me-3 small">
                        <i class="bi bi-person-fill me-1"></i> {{ auth()->user()->nombre }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                            <i class="bi bi-power me-1"></i> Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
