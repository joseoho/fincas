<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AnimalController;


Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();



// Grupo de rutas protegidas por autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
Route::resource('fincas', FincaController::class);
Route::resource('lotes', LoteController::class)->middleware('auth');
Route::resource('animales', AnimalController::class)
    ->parameters(['animales' => 'animal'])
    ->middleware('auth');
// Route::get('/animales/{animal}/edit', [AnimalController::class, 'edit'])->name('animales.edit');

// Route::get('lotes/{lote}/edit', [LoteController::class, 'edit'])->name('lotes.edit');
////para reportes
Route::get('lotes/{lote}/reporte', [LoteController::class, 'reporte'])->name('lotes.reporte')->middleware('auth');
    
    // Ruta show personalizada para mejor SEO
    Route::get('fincas/{finca}', [FincaController::class, 'show'])
         ->name('fincas.show')
         ->where('finca', '[0-9]+');
    
    // Rutas adicionales para reportes
//     Route::prefix('fincas/{finca}')->group(function () {
//         Route::get('inventario', [FincaController::class, 'reporteInventario'])
//              ->name('fincas.inventario');
        
//         Route::get('reporte-financiero', [FincaController::class, 'reporteFinanciero'])
//              ->name('fincas.reporte-financiero');
//     });
    
    // Ruta API para select2 u otros usos
    Route::get('api/fincas', [FincaController::class, 'getFincasJson'])
         ->name('api.fincas');
});
