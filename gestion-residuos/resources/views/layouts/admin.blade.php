<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Sistema Municipal de Gestión de Residuos</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .navbar-brand {
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
        }

        .navbar-dark .navbar-nav .nav-link {
            color: rgba(255, 255, 255, .8);
        }

        .navbar-dark .navbar-nav .nav-link:hover {
            color: #fff;
        }

        .main-content {
            padding-top: 2rem;
            padding-bottom: 4rem;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-trash3-fill me-2"></i>Gestión Municipal de Residuos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold text-white' : '' }}"
                            href="{{ route('admin.dashboard') }}">Panel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.denuncias.*') ? 'active fw-bold text-white' : '' }}"
                            href="{{ route('admin.denuncias.index') }}">Denuncias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.usuarios.*') ? 'active fw-bold text-white' : '' }}"
                            href="{{ route('admin.usuarios.index') }}">Usuarios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active fw-bold text-white' : '' }}"
                            href="{{ route('admin.roles.index') }}">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.camiones.*') ? 'active fw-bold text-white' : '' }}"
                            href="{{ route('admin.camiones.index') }}">Camiones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.cuadrillas.*') ? 'active fw-bold text-white' : '' }}"
                            href="{{ route('admin.cuadrillas.index') }}">Cuadrillas</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <span class="text-white-50 me-3 small">
                        <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->nombre }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm fw-bold">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
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