<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas de Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de Registro
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

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

    // Mapa y Puntos Verdes (Vistas simplificadas por ahora municipal)
    Route::get('/mapa', function () { return view('ciudadano.hub'); })->name('mapa');
    Route::get('/puntos-verdes', function () { return view('ciudadano.hub'); })->name('puntos-verdes');
});

// Rutas para el Administrador Municipal
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
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
});
