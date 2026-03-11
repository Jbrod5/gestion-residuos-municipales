<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - XelaLimpia</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>

<body class="bg-light" style="min-height: 100vh;">
    <!-- Navbar ADMIN con fondo negro -->
    <nav class="navbar navbar-expand-lg bg-dark shadow-sm sticky-top py-3" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-shield-lock-fill me-2 text-warning"></i>
                <span class="text-white">XELA<span class="text-warning">LIMPIA</span></span>
                <span class="badge bg-warning text-dark ms-2">ADMIN</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active fw-bold text-warning' : 'text-white-50' }}" 
                           href="{{ route('admin.dashboard') }}">
                           <i class="bi bi-speedometer2 me-1"></i>Panel
                        </a>
                    </li>

                    <!-- Gestión de Usuarios -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.usuarios.*') || request()->routeIs('admin.roles.*') ? 'active fw-bold text-warning' : 'text-white-50' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                           <i class="bi bi-people me-1"></i>Usuarios
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}" href="{{ route('admin.usuarios.index') }}">Gestionar Usuarios</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">Roles</a></li>
                        </ul>
                    </li>

                    <!-- Logística -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.camiones.*') || request()->routeIs('admin.cuadrillas.*') ? 'active fw-bold text-warning' : 'text-white-50' }}" 
                           href="#" role="button" data-bs-toggle="dropdown">
                           <i class="bi bi-truck me-1"></i>Logística
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ request()->routeIs('admin.camiones.*') ? 'active' : '' }}" href="{{ route('admin.camiones.index') }}">Camiones</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('admin.cuadrillas.*') ? 'active' : '' }}" href="{{ route('admin.cuadrillas.index') }}">Cuadrillas</a></li>
                        </ul>
                    </li>

                    <!-- Infraestructura -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.puntos-verdes.*') ? 'active fw-bold text-warning' : 'text-white-50' }}" 
                           href="{{ route('admin.puntos-verdes.index') }}">
                           <i class="bi bi-tree me-1"></i>Puntos Verdes
                        </a>
                    </li>

                    <!-- Configuración -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.tipos-residuo.*') ? 'active fw-bold text-warning' : 'text-white-50' }}" 
                           href="{{ route('admin.tipos-residuo.index') }}">
                           <i class="bi bi-tag me-1"></i>Tipos de Residuo
                        </a>
                    </li>

                    <!-- Reportes -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reportes.*') ? 'active fw-bold text-warning' : 'text-white-50' }}" 
                           href="{{ route('admin.reportes.index') }}">
                           <i class="bi bi-bar-chart me-1"></i>Reportes
                        </a>
                    </li>
                </ul>

                <div class="d-flex align-items-center">
                    <div class="me-3 text-end">
                        <small class="text-white-50 d-block">Administrador</small>
                        <span class="text-white small fw-bold">{{ auth()->user()->nombre }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-warning btn-sm fw-bold border-2">
                            <i class="bi bi-box-arrow-right me-1"></i> Salir
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