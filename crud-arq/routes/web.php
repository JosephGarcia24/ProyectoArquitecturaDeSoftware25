<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('home');
});

Route::delete('empleados/destroy-multiple', [EmpleadoController::class, 'destroyMultiple'])->name('empleados.destroyMultiple');
Route::resource('empleados', EmpleadoController::class);
