<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MachineTypeController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\AllocationEndMotiveController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\TrailController;
use App\Http\Controllers\ConstructionController;

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

require __DIR__.'/auth.php';

Route::get('/obras', function () {
    return view('obras');
})->middleware(['auth', 'verified'])->name('obras');

// Route::get('/maquinas', [MachineTypeController::class, 'index'])->middleware(['auth', 'verified'])->name('maquinas');
Route::get('/maquinas', function () {
    return view('maquinas');
})->middleware(['auth', 'verified'])->name('maquinas');

/// maquinas separada por tipo:
Route::get('/maquinas/by_type/{id}', [MachineController::class, 'get_by_type'])->middleware(['auth', 'verified']);

Route::get('/maquinas/mostrar/{id}', [MachineController::Class, "show"])->middleware(['auth', 'verified'])->name('machine.show');

Route::get('/maquinas/asignacion/{id}', [AllocationController::Class, "show"])->middleware(['auth', 'verified'])->name('allocation.show');


///Obtener motivos de end allocations
Route::get('/allocations/mostrar', [AllocationEndMotiveController::class, 'index'])->middleware(['auth', 'verified'])->name('end_motives');

/// Editar allocation:
Route::patch('/allocation/update', [AllocationController::class, 'update'])->middleware(['auth', 'verified'])->name('allocation.update');

/// guardar trail
Route::patch('/trail/store', [TrailController::class, 'store'])->middleware(['auth', 'verified'])->name('trail.store');


//// VIEW OBRAS
Route::get('/obras/by_province/{id}', [ConstructionController::class, 'get_by_province'])->middleware(['auth', 'verified']);

/// una obra:
Route::get('/obras/mostrar/{id}', [ConstructionController::Class, "show"])->middleware(['auth', 'verified'])->name('construction.show');


/// RUTA DE PRUEBAS
Route::get('/obras/prueba/{id}', [ConstructionController::class, 'prueba'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/maquinas/prueba/{id}', [MachineController::class, 'prueba'])->withoutMiddleware([VerifyCsrfToken::class]);


///Ir al form de allocation
Route::get('/allocation/create', [AllocationController::Class, "create"])->middleware(['auth', 'verified'])->name('allocation.create');
