<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operador - Gestión Municipal</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f7f6;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .main-container {
            padding-top: 3rem;
            padding-bottom: 5rem;
        }

        .card {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('operador.dashboard') }}">
                <i class="bi bi-recycle pe-2"></i>Operador Punto Verde
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navOperador">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navOperador">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('operador.dashboard') ? 'active' : '' }}"
                            href="{{ route('operador.dashboard') }}">Dashboard</a>
                    </li>
                    @if(auth()->user()->id_punto_verde)

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('operador.historial.index') ? 'active' : '' }}"
                            href="{{ route('operador.historial.index') }}">Historial</a>
                    </li>
                    @endif
                </ul>

                <span class="navbar-text me-3 text-white small">
                    <i class="bi bi-person-fill me-1"></i> {{ auth()->user()->nombre }}
                </span>

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                        <i class="bi bi-power me-1"></i> Salir
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container main-container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>