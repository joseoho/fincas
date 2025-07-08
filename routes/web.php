<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FincaController;
use App\Http\Controllers\LoteController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AnimalHistoricaController;
use App\Http\Controllers\TransaccionController;
use App\Http\Controllers\TransaccionHistoricaController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReporteAnimalesController;
use App\Http\Controllers\MovimientoanimalesController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();



// Grupo de rutas protegidas por autenticación y verificación de email
Route::middleware(['auth', 'verified'])->group(function () {
Route::resource('fincas', FincaController::class);
Route::resource('movimientos', MovimientoanimalesController::class);
Route::resource('lotes', LoteController::class);//->middleware('auth');
Route::resource('transacciones', TransaccionController::class)
    ->parameters(['transacciones' => 'transaccion']);//Esto es un problema común con la convención de nombres en Laravel.
Route::resource('animales', AnimalController::class)
->parameters(['animales' => 'animal'])//Esto es un problema común con la convención de nombres en Laravel.
->middleware('auth');
Route::get('/transacciones/reportes', [TransaccionController::class, 'reportes'])->name('transacciones.reportes');
Route::resource('reportes', ReporteController::class);
Route::get('/reportes/pdf', [ReporteController::class, 'generarPdf'])->name('reportes.pdf');
Route::resource('reportesanimales', ReporteAnimalesController::class);
Route::resource('transaccioneshistoricas', TransaccionHistoricaController::class);
Route::resource('animaleshistoricas', AnimalHistoricaController::class);



    // Ruta show personalizada para mejor SEO
    Route::get('fincas/{finca}', [FincaController::class, 'show'])
         ->name('fincas.show')
         ->where('finca', '[0-9]+');
    
     // Ruta API para select2 u otros usos
    Route::get('api/fincas', [FincaController::class, 'getFincasJson'])
         ->name('api.fincas');
});
