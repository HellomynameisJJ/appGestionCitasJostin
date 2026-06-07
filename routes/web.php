<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CitaController;

/*
|--------------------------------------------------------------------------
| Web Routes - SANAR+ (Interfaz Gráfica)
|--------------------------------------------------------------------------
*/

// 1. Ruta principal (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// 2. Rutas automáticas de Autenticación de Laravel (Login, Register)
Auth::routes();

// 3. Ruta del panel o dashboard principal post-login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 4. Rutas de autenticación con Google y GitHub Socialite
Route::get('/login/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);
Route::get('/login/github', [LoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('/login/github/callback', [LoginController::class, 'handleGithubCallback']);


// 5. 🔒 ESTO ROMPE EL BUCLE DEFINITIVAMENTE:
// Protege los 6 módulos asegurando que Laravel reconozca tu sesión activa en la web.
Route::middleware('auth')->group(function () {
    
    Route::resource('pacientes', App\Http\Controllers\PacienteController::class);
    Route::resource('citas', CitaController::class);
    Route::resource('medicos', App\Http\Controllers\MedicoController::class);
    Route::resource('diagnosticos', App\Http\Controllers\DiagnosticoController::class);
    Route::resource('tratamientos', App\Http\Controllers\TratamientoController::class);
    Route::resource('medicamentos', App\Http\Controllers\MedicamentoController::class);

    // Rutas específicas adicionales que tenías abajo para tus formularios
    Route::get('/citas/{id}/edit', [CitaController::class, 'edit'])->name('citas.edit');
    Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');
    
    Route::post('/medicos', [App\Http\Controllers\MedicoController::class, 'store'])->name('medicos.store');
    Route::post('/diagnosticos', [App\Http\Controllers\DiagnosticoController::class, 'store'])->name('diagnosticos.store');
    Route::put('/diagnosticos/{id}', [App\Http\Controllers\DiagnosticoController::class, 'update'])->name('diagnosticos.update');
});