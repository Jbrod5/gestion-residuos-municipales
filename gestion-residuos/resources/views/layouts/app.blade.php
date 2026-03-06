<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión municipal de residuos</title>
    
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <style>
        body { 
            background-color: #f4f6f9; 
            min-height: 100vh;
        }
    </style>
</head>
<body>

    <div class="container-fluid py-4">
        @yield('content')
    </div>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>