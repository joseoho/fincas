<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\ReporteController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();



// Grupo de rutas protegidas por autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
Route::resource('fincas', FincaController::class);
Route::resource('lotes', LoteController::class)->middleware('auth');
Route::resource('transacciones', TransaccionController::class)
    ->parameters(['transacciones' => 'transaccion']);//Esto es un problema común con la convención de nombres en Laravel.
Route::get('/transacciones/reportes', [TransaccionController::class, 'reportes'])->name('transacciones.reportes');
Route::get('/transacciones/generar-pdf', [TransaccionController::class, 'generarPdf'])->name('transacciones.generar.pdf');
// Route::get('transacciones/exportar', [TransaccionController::class, 'exportar'])
//     ->name('transacciones.exportar') para esxportar
//     ->middleware('auth');
Route::resource('reportes', ReporteController::class);
Route::get('/reportes/pdf', [ReporteController::class, 'generarPdf'])->name('reportes.pdf');
Route::resource('animales', AnimalController::class)
    ->parameters(['animales' => 'animal'])//Esto es un problema común con la convención de nombres en Laravel.
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
