<?php
// routes/api.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\PermisoController;

// Rutas públicas (sin autenticación)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    // Autenticación
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Propietarios (API Resource)
    Route::get('/propietarios', [PropietarioController::class, 'index']);
    Route::post('/propietarios', [PropietarioController::class, 'store']);
    Route::get('/propietarios/{id}', [PropietarioController::class, 'show']);
    Route::put('/propietarios/{id}', [PropietarioController::class, 'update']);
    Route::delete('/propietarios/{id}', [PropietarioController::class, 'destroy']);

    // Tiendas (API Resource)
    Route::get('/tiendas', [TiendaController::class, 'index']);
    Route::post('/tiendas', [TiendaController::class, 'store']);
    Route::get('/tiendas/{id}', [TiendaController::class, 'show']);
    Route::put('/tiendas/{id}', [TiendaController::class, 'update']);
    Route::delete('/tiendas/{id}', [TiendaController::class, 'destroy']);

    // Permisos (API Resource)
    Route::get('/permisos', [PermisoController::class, 'index']);
    Route::post('/permisos', [PermisoController::class, 'store']);
    Route::get('/permisos/{id}', [PermisoController::class, 'show']);
    Route::put('/permisos/{id}', [PermisoController::class, 'update']);
    Route::delete('/permisos/{id}', [PermisoController::class, 'destroy']);

    // Alternativamente, podrías usar apiResource para simplificar:
    // Route::apiResource('propietarios', PropietarioController::class);
    // Route::apiResource('tiendas', TiendaController::class);
    // Route::apiResource('permisos', PermisoController::class);
});