<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;
use App\Http\Controllers\AhorroController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\GastoFijoController;
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



// CRUD VISTAS
Route::resource('ingresos', IngresoController::class);
Route::resource('egresos', EgresoController::class);
Route::resource('ahorros', AhorroController::class);
Route::resource('periodos', PeriodoController::class);
Route::resource('gastos-fijos', GastoFijoController::class);

// Rutas
Route::get('/ingresos/fechas/{inicio}/{fin}', [IngresoController::class, 'buscarFechas'])->name('ingresos.fechas');
Route::get('/ingresos/ultimos/10', [IngresoController::class, 'buscarUltimos10'])->name('ingresos.ultimos');
Route::get('/ingresos/rango/{min}/{max}', [IngresoController::class, 'buscarRango'])->name('ingresos.rango');
Route::get('/ingresos/total', [IngresoController::class, 'totalActual'])->name('ingresos.total');

Route::get('/egresos/fecha/{fecha}', [EgresoController::class, 'buscarFecha'])->name('egresos.fecha');
Route::get('/egresos/ultimos/{cantidad?}', [EgresoController::class, 'buscarUltimos'])->name('egresos.ultimos');
Route::get('/egresos/rango/{min}/{max}', [EgresoController::class, 'buscarRango'])->name('egresos.rango');

Route::get('/ahorros/total', [AhorroController::class, 'total'])->name('ahorros.total');

Route::get('/gastos-fijos/alerta/{limite}', [GastoFijoController::class, 'alerta'])->name('gastos.alerta');
Route::get('/gastos-fijos/{gastoFijo}/egresos-alerta', [GastoFijoController::class, 'egresoXAlerta'])->name('gastos.egresos_alerta');

Route::get('/ahorros/{ahorro}/ingresos/create', [AhorroController::class, 'agregarIngresoForm'])->name('ahorros.ingresos.create');
Route::post('/ahorros/{ahorro}/ingresos', [AhorroController::class, 'asociarIngreso'])->name('ahorros.ingresos.store');

Route::delete('ahorros/{ahorro}/ingresos/{ingreso}', [AhorroController::class, 'eliminarIngreso'])->name('ahorros.ingresos.eliminar');

