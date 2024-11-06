<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\UserController;

Route::view('/', 'welcome')->middleware('guest'); // Redirige a usuarios no autenticados

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Ruta para el panel de control
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth']) 
    ->name('dashboard');

// Ruta para el perfil de usuario
Route::view('/profile', 'profile')
    ->middleware(['auth']) 
    ->name('profile');

    // Rutas para la gestión de incidencias
Route::middleware(['auth'])->group(function () {
    Route::get('/incidencias', [IncidenciaController::class, 'index'])->name('incidencias.index');
    Route::get('/incidencias/create', [IncidenciaController::class, 'create'])->name('incidencias.create');
    Route::post('/incidencias/store', [IncidenciaController::class, 'store'])->name('incidencias.store');
    Route::get('/incidencias/{incidencia}/edit', [IncidenciaController::class, 'edit'])->name('incidencias.edit');
    Route::put('/incidencias/{incidencia}', [IncidenciaController::class, 'update'])->name('incidencias.update');
    Route::delete('/incidencias/{incidencia}', [IncidenciaController::class, 'destroy'])->name('incidencias.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios/soporte', [UserController::class, 'showUsers'])->name('usuarios.soporte');
    Route::get('/usuarios/incidencias/{id}', [UserController::class, 'showUserIncidencias'])->name('usuarios.incidencias');
    Route::get('/usuarios/{user}/incidencias/create', [IncidenciaController::class, 'createUserInc'])->name('usuarios.incidencias.create');
    Route::post('/usuarios/incidencias', [IncidenciaController::class, 'storeUserInc'])->name('usuarios.incidencias.store');
    Route::get('/usuarios/incidencia/{incidencia}/edit', [IncidenciaController::class, 'editUserInc'])->name('usuarios.incidencias.edit');
    Route::put('/usuarios/incidencias/{incidencia}', [IncidenciaController::class, 'updateUserInc'])->name('usuarios.incidencias.update');
    Route::delete('/usuarios/incidencias/{incidencia}', [IncidenciaController::class, 'destroyUserInc'])->name('usuarios.incidencias.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios/create', [UserController::class, 'createUser'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'storeUser'])->name('usuarios.store');
    Route::delete('/usuarios/{id}', [UserController::class, 'destroyUser'])->name('usuarios.destroy');
});




require __DIR__.'/auth.php';
