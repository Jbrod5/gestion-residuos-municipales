<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinador - Sistema Municipal de Gestión de Residuos</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f0f2f5;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #ffc107 !important;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
        }

        .main-content {
            padding-top: 2rem;
            padding-bottom: 4rem;
        }

        .card-coordinator {
            border: none;
            border-radius: 12px;
            transition: transform 0.2s;
        }

        .card-coordinator:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('coordinator.dashboard') }}">
                <i class="bi bi-map-fill me-2"></i>Logística Municipal
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#coordinatorNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="coordinatorNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.dashboard') ? 'active fw-bold text-warning' : '' }}"
                            href="{{ route('coordinator.dashboard') }}">Panel de Control</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.rutas.*') ? 'active fw-bold text-warning' : '' }}"
                            href="{{ route('coordinator.rutas.index') }}">Rutas de Recolección</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.asignaciones.*') ? 'active fw-bold text-warning' : '' }}"
                            href="{{ route('coordinator.asignaciones.index') }}">Asignación de Rutas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.denuncias.*') ? 'active' : '' }}" 
                        href="{{ route('coordinator.denuncias.index') }}">
                            <i class="nav-icon fas fa-exclamation-triangle text-warning"></i>
                            <p>Gestión de Denuncias</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('coordinator.solicitudes.*') ? 'active fw-bold text-warning' : '' }}"
                            href="{{ route('coordinator.solicitudes.index') }}">Solicitudes de Vaciado</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="text-white-50 me-3 small">
                        <i class="bi bi-person-check-fill me-1"></i> Coordinador: {{ auth()->user()->nombre }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm fw-bold">
                            <i class="bi bi-door-open-fill me-1"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container main-content">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
