<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
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
});
