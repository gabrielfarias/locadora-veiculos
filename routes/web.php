<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
    //return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::middleware('auth')->group(
    function () {
        Route::get('/veiculos', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/veiculos/editar/{id}', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/veiculos/editar/{id}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::get('/veiculos/criar', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/veiculos', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::delete('/veiculos/{id}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        Route::get('/usuarios', [UserController::class, 'index'])->name('users.index');
        Route::get('/usuarios/editar/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/usuarios/editar/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/usuarios/criar', [UserController::class, 'create'])->name('users.create');
        Route::post('/usuarios', [UserController::class, 'store'])->name('users.store');
        Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/reservas', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservas/relatorio', [ReservationController::class, 'report'])->name('reservation.report');
    }
);

require __DIR__ . '/auth.php';
