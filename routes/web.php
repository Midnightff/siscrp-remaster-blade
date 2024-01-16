<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AntecedentesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\TratamientoController;
use App\Models\Doctor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rutas de inicio de sesión y registro
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});


// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {

    // Rutas del dashboard
    Route::get('/inicio', [AdminController::class, 'dash'])->name('admin.dash')->middleware('checkType:1');
    require __DIR__ . '/auth.php';

    // Rutas de tratamientos
    Route::resource('tratamientos', TratamientoController::class);
    require __DIR__ . '/auth.php';

    // Rutas de pacientes
    Route::resource('pacientes', PacienteController::class);
    Route::get('/verificar-paciente', [PacienteController::class, 'verificarPaciente'])->name('verificar-paciente');
    Route::get('/crear-paciente', [PacienteController::class, 'crearPaciente'])->name('crear-paciente');
    Route::post('/paciente-crear', [PacienteController::class, 'storeCliente'])->name('store-cliente');
    Route::get('/obtener-pacientes', [PacienteController::class, 'showPacientes'])->name('obtener-pacientes');
    Route::get('/pacientes-cliente', [PacienteController::class, 'Pacientes'])->name('pacientes');
    Route::get('/obtener-cantidad-pacientes', [PacienteController::class, 'obtenerCantidadPacientes'])->name('obtener-cantidad-pacientes');


    require __DIR__ . '/auth.php';

    // Rutas de doctores
    Route::resource('doctores', DoctorController::class);
    require __DIR__ . '/auth.php';

    // Rutas de citas
    Route::resource('citas', CitaController::class);
    Route::get('/disponibilidad', [CitaController::class, 'disponibilidad'])->name('disponibilidad');
    Route::get('/getHorasOcupadas/{fechaSeleccionada}', [CitaController::class, 'getHorasOcupadas'])->name('getHorasOcupadas');
    Route::post('/agendar-cita', [CitaController::class, 'storeCita'])->name('store.cita');
    require __DIR__ . '/auth.php';

    // Rutas de citas
    Route::resource('publicaciones', PublicacionesController::class);
    require __DIR__ . '/auth.php';

    // Rutas de citas
    Route::resource('antecedentes', AntecedentesController::class);
    require __DIR__ . '/auth.php';
});




Route::get('/', [AdminController::class, 'welcome'])->name('welcome');
require __DIR__ . '/auth.php';
