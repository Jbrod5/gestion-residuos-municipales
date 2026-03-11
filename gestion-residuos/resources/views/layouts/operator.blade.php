<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Operador') - XelaLimpia</title>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @stack('styles')
</head>

<body class="bg-light" style="min-height: 100vh;">
    <!-- Navbar OPERADOR con fondo VERDE MENTA/TURQUESA -->
    <nav class="navbar navbar-expand-lg" style="background-color: #20c997; box-shadow: 0 4px 12px rgba(0,0,0,0.1);" data-bs-theme="light">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('operador.dashboard') }}">
                <i class="bi bi-recycle me-2 text-white"></i>
                <span class="text-white">XELA<span class="text-white fw-bolder" style="text-shadow: 0 2px 4px rgba(0,0,0,0.2);">LIMPIA</span></span>
                <span class="badge bg-white text-dark ms-2" style="color: #20c997 !important;">OPERADOR</span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#operadorNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="operadorNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('operador.dashboard') ? 'active fw-bold text-white' : 'text-white opacity-75' }}" 
                           href="{{ route('operador.dashboard') }}">
                           <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>

                    @if(auth()->user()->id_punto_verde)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('operador.entrega.create') ? 'active fw-bold text-white' : 'text-white opacity-75' }}" 
                           href="{{ route('operador.entrega.create') }}">
                           <i class="bi bi-plus-circle me-1"></i>Registrar Entrega
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('operador.historial.index') ? 'active fw-bold text-white' : 'text-white opacity-75' }}" 
                           href="{{ route('operador.historial.index') }}">
                           <i class="bi bi-clock-history me-1"></i>Historial
                        </a>
                    </li>
                    @endif
                </ul>

                <div class="d-flex align-items-center">
                    <div class="me-3 text-end">
                        <small class="text-white opacity-75 d-block">
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            @if(auth()->user()->puntoVerde)
                                {{ auth()->user()->puntoVerde->nombre }}
                            @else
                                Sin punto asignado
                            @endif
                        </small>
                        <span class="text-white fw-bold">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->nombre }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm fw-bold border-2">
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
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #20c997;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4">
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-left: 4px solid #dc3545;">
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
    @stack('scripts')
</body>
</html>