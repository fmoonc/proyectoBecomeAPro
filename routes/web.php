<?php

use App\Http\Controllers\CuentaController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/**
 * Agrupacion de rutas para admin
 */
Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function () {
    Route::get('Admin/', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin');
});

/**
 * Agrupacion de rutas para usuarios
 */
Route::group(['middleware' => 'App\Http\Middleware\UserMiddleware'], function () {
    Route::get('User/', [App\Http\Controllers\HomeController::class, 'user'])->name('user');
    //Route::resource('/User/cuenta', CuentaController::class);
    Route::get('User/Account', [App\Http\Controllers\CuentaController::class, 'index'])->name('indice');
    Route::post('User/Account/Add', [App\Http\Controllers\CuentaController::class, 'store'])->name('add');
    Route::delete('User/DeleteAccount/{id}', [App\Http\Controllers\CuentaController::class, 'destroy'])->name('delete');
    Route::put('User/EditAccount/{id}', [App\Http\Controllers\CuentaController::class, 'update'])->name('update');
    Route::get('User/Partidos', [App\Http\Controllers\PartidoController::class, 'index'])->name('partidos');
});