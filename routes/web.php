<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AntecedentesController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\TratamientoController;
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

//dash adminlte
Route::get('/inicio', [AdminController::class, 'dash'])->name('admin.dash');
// Route::get('/show-paciente', [AdminController::class, 'pacients'])->name('admin.pacientes');

//tratamientos admin
Route::resource('tratamientos', TratamientoController::class);
require __DIR__.'/auth.php';

//pacientes admin
Route::resource('pacientes', PacienteController::class);
require __DIR__.'/auth.php';

//antecedentes admin
Route::resource('antecedentes', AntecedentesController::class);
require __DIR__.'/auth.php';
Route::get('antecedente/{paciente_id}', [AntecedentesController::class,'showAntecedenteByPacient'])->name('antecedente');

//publicaciones admin
Route::resource('publicaciones', PublicacionesController::class);
require __DIR__.'/auth.php';
Route::get('publicaciones/{publicacion_id}', [PublicacionesController::class, 'show'])->name('publicacion');
