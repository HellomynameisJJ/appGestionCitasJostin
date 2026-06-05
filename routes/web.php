<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CitaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 1. Ruta principal (Welcome) - Carga la landing page informativa de SANAR+
Route::get('/', function () {
    return view('welcome');
});

// 2. Rutas automáticas de Autenticación de Laravel (Login, Register, Passwords)
Auth::routes();

// 3. Ruta del panel o dashboard principal post-login
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 4. Rutas de autenticación con Google Socialite
// Esta ruta redirige al usuario hacia los servidores de Google
Route::get('/login/google', [LoginController::class, 'redirectToGoogle']);

// Esta es la URL de retorno (Callback) que procesa la respuesta de Google
Route::get('/login/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/login/github', [LoginController::class, 'redirectToGithub'])->name('login.github');

// Recibe la respuesta de GitHub
Route::get('/login/github/callback', [LoginController::class, 'handleGithubCallback']);

// Rutas temporales para que el menú de Home no lance error 404/500
Route::resource('pacientes', App\Http\Controllers\PacienteController::class);
Route::resource('citas', CitaController::class); // Esta línea carga automáticamente index, create, store, etc.
Route::resource('medicos', App\Http\Controllers\MedicoController::class);
Route::resource('diagnosticos', App\Http\Controllers\DiagnosticoController::class);
Route::resource('tratamientos', App\Http\Controllers\TratamientoController::class);
Route::resource('medicamentos', App\Http\Controllers\MedicamentoController::class);

Route::post('/medicos', [App\Http\Controllers\MedicoController::class, 'store'])->name('medicos.store');

Route::get('/citas/{id}/edit', [App\Http\Controllers\CitaController::class, 'edit'])->name('citas.edit');
Route::put('/citas/{id}', [App\Http\Controllers\CitaController::class, 'update'])->name('citas.update');

Route::get('/medicos', [App\Http\Controllers\MedicoController::class, 'index'])->name('medicos.index');
Route::post('/medicos', [App\Http\Controllers\MedicoController::class, 'store'])->name('medicos.store');

Route::get('/diagnosticos', [App\Http\Controllers\DiagnosticoController::class, 'index'])->name('diagnosticos.index');
Route::post('/diagnosticos', [App\Http\Controllers\DiagnosticoController::class, 'store'])->name('diagnosticos.store');
Route::put('/diagnosticos/{id}', [App\Http\Controllers\DiagnosticoController::class, 'update'])->name('diagnosticos.update');