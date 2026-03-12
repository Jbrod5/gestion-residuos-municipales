<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PuntoVerdePublicController;

Route::get('/', function () {
    return redirect()->route('login');
});

// ===== RUTAS PÚBLICAS (SIN AUTENTICACIÓN) =====
Route::get('/mapa-recoleccion', [App\Http\Controllers\Publico\MapaController::class, 'mapaRecoleccion'])->name('publico.mapa');
Route::get('/puntos-verdes-publico', [App\Http\Controllers\Publico\MapaController::class, 'puntosVerdes'])->name('publico.puntos');

// APIs públicas
Route::get('/publico/rutas', [App\Http\Controllers\Publico\MapaController::class, 'apiRutas'])->name('publico.api.rutas');
Route::get('/publico/puntos-verdes', [App\Http\Controllers\Publico\MapaController::class, 'apiPuntosVerdes'])->name('publico.api.puntos');



// Rutas de Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de Registro
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Ruta publica para mapa de puntos verdes
Route::get('/puntos-verdes', [PuntoVerdePublicController::class, 'index'])->name('puntos-verdes');

// Rutas para el Ciudadano (Módulo de Denuncias)
Route::group(['prefix' => 'ciudadano', 'as' => 'ciudadano.', 'middleware' => 'auth'], function () {
    // Hub principal
    Route::get('/hub', function () {
        return view('ciudadano.hub');
    })->name('hub');

    // Módulo de Denuncias
    Route::get('/denuncias', [\App\Http\Controllers\Ciudadano\DenunciaController::class, 'index'])->name('denuncias.index');
    Route::get('/denuncias/nueva', [\App\Http\Controllers\Ciudadano\DenunciaController::class, 'create'])->name('denuncias.create');
    Route::get('/denuncias/{id_denuncia}', [\App\Http\Controllers\Ciudadano\DenunciaController::class, 'show'])->name('denuncias.show');
    Route::post('/denuncias', [\App\Http\Controllers\Ciudadano\DenunciaController::class, 'store'])->name('denuncias.store');

    // Mapa de rutas de recoleccion para el ciudadano
    Route::get('/mapa-recoleccion', [\App\Http\Controllers\Ciudadano\RutaPublicaController::class, 'index'])->name('mapa');
    Route::get('/api/rutas', [\App\Http\Controllers\Ciudadano\RutaPublicaController::class, 'apiRutas'])->name('api.rutas');
});

// Rutas para el Administrador Municipal
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'role:1']], function () {
    // Dashboard administrativo
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'dashboard'])->name('dashboard');

    // Gestión de Denuncias
    Route::get('/denuncias', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'index'])->name('denuncias.index');
    Route::patch('/denuncias/{id_denuncia}/estado', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'updateStatus'])->name('denuncias.update');

    // Gestión de Usuarios Municipales
    Route::get('/usuarios', [\App\Http\Controllers\Admin\UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/nuevo', [\App\Http\Controllers\Admin\UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [\App\Http\Controllers\Admin\UsuarioController::class, 'store'])->name('usuarios.store');
    Route::delete('/usuarios/{id}', [\App\Http\Controllers\Admin\UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // Gestión de Roles Dinámicos
    Route::get('/roles', [\App\Http\Controllers\Admin\RolController::class, 'index'])->name('roles.index');
    Route::get('/roles/nuevo', [\App\Http\Controllers\Admin\RolController::class, 'create'])->name('roles.create');
    Route::post('/roles', [\App\Http\Controllers\Admin\RolController::class, 'store'])->name('roles.store');

    // Gestión de Logística: Camiones
    Route::get('/camiones', [\App\Http\Controllers\Admin\CamionController::class, 'index'])->name('camiones.index');
    Route::get('/camiones/nuevo', [\App\Http\Controllers\Admin\CamionController::class, 'create'])->name('camiones.create');
    Route::post('/camiones', [\App\Http\Controllers\Admin\CamionController::class, 'store'])->name('camiones.store');
    Route::get('/camiones/{id}/editar', [\App\Http\Controllers\Admin\CamionController::class, 'edit'])->name('camiones.edit');
    Route::patch('/camiones/{id}', [\App\Http\Controllers\Admin\CamionController::class, 'update'])->name('camiones.update');

    // Gestión de Logística: Cuadrillas
    Route::get('/cuadrillas', [\App\Http\Controllers\Admin\CuadrillaController::class, 'index'])->name('cuadrillas.index');
    Route::get('/cuadrillas/nueva', [\App\Http\Controllers\Admin\CuadrillaController::class, 'create'])->name('cuadrillas.create');
    Route::post('/cuadrillas', [\App\Http\Controllers\Admin\CuadrillaController::class, 'store'])->name('cuadrillas.store');
    Route::get('/cuadrillas/{id}/personal', [\App\Http\Controllers\Admin\CuadrillaController::class, 'personal'])->name('cuadrillas.personal');
    Route::post('/cuadrillas/{id}/personal', [\App\Http\Controllers\Admin\CuadrillaController::class, 'asignarPersonal'])->name('cuadrillas.asignar');
    Route::delete('/cuadrillas/{id_cuadrilla}/personal/{id_usuario}', [\App\Http\Controllers\Admin\CuadrillaController::class, 'desasignarPersonal'])->name('cuadrillas.desasignar');

    // Asignación de Denuncias a Cuadrillas
    Route::post('/asignaciones', [\App\Http\Controllers\Admin\AsignacionController::class, 'store'])->name('asignaciones.store');
    Route::post('/denuncias/{id}/finalizar', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'finalizar'])->name('denuncias.finalizar');

    // Gestión de Puntos Verdes (Mapeo de Infraestructura municipal)
    Route::get('/puntos-verdes', [\App\Http\Controllers\Admin\PuntoVerdeController::class, 'index'])->name('puntos-verdes.index');
    Route::get('/puntos-verdes/nuevo', [\App\Http\Controllers\Admin\PuntoVerdeController::class, 'create'])->name('puntos-verdes.create');
    Route::post('/puntos-verdes', [\App\Http\Controllers\Admin\PuntoVerdeController::class, 'store'])->name('puntos-verdes.store');
    Route::get('/puntos-verdes/{id}/editar', [\App\Http\Controllers\Admin\PuntoVerdeController::class, 'edit'])->name('puntos-verdes.edit');
    Route::patch('/puntos-verdes/{id}', [\App\Http\Controllers\Admin\PuntoVerdeController::class, 'update'])->name('puntos-verdes.update');
    Route::delete('/puntos-verdes/{id}', [\App\Http\Controllers\Admin\PuntoVerdeController::class, 'destroy'])->name('puntos-verdes.destroy');

    // Dashboard de reportes con chartjs
    Route::get('/reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/api/reportes', [\App\Http\Controllers\ReporteController::class, 'apiDatos'])->name('reportes.api');

    // Gestión de Tipos de Residuo
    Route::resource('tipos-residuo', \App\Http\Controllers\Admin\TipoResiduoController::class)
        ->except(['show'])
        ->parameters(['tipos-residuo' => 'id']);
    Route::get('tipos-residuo/{id}', [\App\Http\Controllers\Admin\TipoResiduoController::class, 'show'])
        ->name('tipos-residuo.show');

    // Zonas:

    Route::prefix('zonas')->name('zonas.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ZonaController::class, 'index'])->name('index');
        Route::post('/', [App\Http\Controllers\Admin\ZonaController::class, 'storeZona'])->name('store');


        Route::post('/tipo', [App\Http\Controllers\Admin\ZonaController::class, 'storeTipoZona'])->name('tipos-zona.store');

        Route::delete('/{id}', [App\Http\Controllers\Admin\ZonaController::class, 'destroyZona'])->name('destroy');

        // APIs para mapa
        Route::get('/api', [App\Http\Controllers\Admin\ZonaController::class, 'apiZonas'])->name('api');
        Route::get('/api/{id}', [App\Http\Controllers\Admin\ZonaController::class, 'apiZona'])->name('api.zona');
    });

});

// Rutas para el Coordinador de Rutas (Módulo 1)
Route::group(['prefix' => 'coordinator', 'as' => 'coordinator.', 'middleware' => ['auth', 'role:2']], function () {
    // Dashboard principal success total
    Route::get('/dashboard', function () {
        return view('coordinator.dashboard');
    })->name('dashboard');

    // Gestión de Rutas Municipal
    Route::get('/rutas', [\App\Http\Controllers\Coordinador\RutaController::class, 'index'])->name('rutas.index');
    Route::get('/rutas/nueva', [\App\Http\Controllers\Coordinador\RutaController::class, 'create'])->name('rutas.create');
    Route::post('/rutas', [\App\Http\Controllers\Coordinador\RutaController::class, 'store'])->name('rutas.store');
    Route::get('/rutas/{id}', [\App\Http\Controllers\Coordinador\RutaController::class, 'show'])->name('rutas.show');

    // Asignación de Rutas Municipal
    Route::get('/asignaciones', [\App\Http\Controllers\Coordinador\AsignacionController::class, 'index'])->name('asignaciones.index');
    Route::get('/asignaciones/nueva', [\App\Http\Controllers\Coordinador\AsignacionController::class, 'create'])->name('asignaciones.create');
    Route::post('/asignaciones', [\App\Http\Controllers\Coordinador\AsignacionController::class, 'store'])->name('asignaciones.store');
    Route::get('/api/disponibilidad-camiones', [\App\Http\Controllers\Coordinador\AsignacionController::class, 'apiDisponibilidad'])->name('api.disponibilidad');

    // gestion de solicitudes de vaciado de puntos verdes
    Route::get('/solicitudes-vaciado', [\App\Http\Controllers\Coordinador\CoordinadorController::class, 'index'])->name('solicitudes.index');
    Route::post('/solicitudes-vaciado/{id_solicitud}/atender', [\App\Http\Controllers\Coordinador\CoordinadorController::class, 'atender'])->name('solicitudes.atender');

    //Denuncias
    Route::get('/denuncias', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'index'])->name('denuncias.index');
    Route::patch('/denuncias/{id_denuncia}/estado', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'updateStatus'])->name('denuncias.update');
    Route::post('/denuncias/{id}/finalizar', [\App\Http\Controllers\Admin\AdminDenunciaController::class, 'finalizar'])->name('denuncias.finalizar');
    Route::post('/asignaciones-denuncias', [\App\Http\Controllers\Admin\AsignacionController::class, 'store'])->name('asignaciones.store');

});

// Rutas para el Operador de Punto Verde (Rol 3)
Route::group(['prefix' => 'operador', 'as' => 'operador.', 'middleware' => ['auth', 'role:3']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Operador\OperadorController::class, 'dashboard'])->name('dashboard');
    Route::get('/entrega/nueva', [\App\Http\Controllers\Operador\OperadorController::class, 'createEntrega'])->name('entrega.create');
    Route::post('/entrega', [\App\Http\Controllers\Operador\OperadorController::class, 'storeEntrega'])->name('entrega.store');
    Route::post('/vaciado/{id_contenedor}', [\App\Http\Controllers\Operador\OperadorController::class, 'solicitarVaciado'])->name('vaciado.solicitar');
    Route::get('/historial', [\App\Http\Controllers\Operador\OperadorController::class, 'historial'])->name('historial.index');
});

// Rutas para el Auditor (Rol 5)
Route::group(['prefix' => 'auditor', 'as' => 'auditor.', 'middleware' => ['auth', 'role:5']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Auditor\AuditorController::class, 'index'])->name('dashboard');
    Route::get('/detalle/{tipo}/{id}', [\App\Http\Controllers\Auditor\AuditorController::class, 'show'])->name('show');
    Route::get('/exportar/recoleccion', [App\Http\Controllers\Auditor\AuditorController::class, 'exportarRecoleccion'])->name('exportar.recoleccion');
    Route::get('/exportar/denuncias', [App\Http\Controllers\Auditor\AuditorController::class, 'exportarDenuncias'])->name('exportar.denuncias');
    Route::get('/exportar/reciclaje', [App\Http\Controllers\Auditor\AuditorController::class, 'exportarReciclaje'])->name('exportar.reciclaje');
    Route::get('/exportar/completo', [App\Http\Controllers\Auditor\AuditorController::class, 'exportarCompleto'])->name('exportar.completo');
Route::get('/api/datos', [\App\Http\Controllers\Auditor\AuditorController::class, 'apiDatos'])->name('api.datos');
    });


// Rutas para el Conductor (Rol 6)
Route::group(['prefix' => 'conductor', 'as' => 'conductor.', 'middleware' => ['auth', 'role:6']], function () {
    Route::get('/dashboard', [\App\Http\Controllers\Conductor\ConductorController::class, 'dashboard'])->name('dashboard');
    Route::get('/asignaciones', [\App\Http\Controllers\Conductor\ConductorController::class, 'index'])->name('asignaciones.index');
    Route::get('/asignaciones/{id_asignacion}', [\App\Http\Controllers\Conductor\ConductorController::class, 'show'])->name('asignaciones.show');
    Route::get('/asignaciones/{id_asignacion}/iniciar', [\App\Http\Controllers\Conductor\ConductorController::class, 'iniciar'])->name('asignaciones.iniciar');
    Route::get('/asignaciones/{id_asignacion}/finalizar', [\App\Http\Controllers\Conductor\ConductorController::class, 'editFinalizar'])->name('asignaciones.finalizar.form');
    Route::post('/asignaciones/{id_asignacion}/finalizar', [\App\Http\Controllers\Conductor\ConductorController::class, 'finalizar'])->name('asignaciones.finalizar');
    Route::get('/api/ruta-actual', [\App\Http\Controllers\Conductor\ConductorController::class, 'apiRutaActual'])->name('api.ruta-actual');
});