<?php

use App\Http\Controllers\NewspaperController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->name('login.index');
    Route::post('/login', 'verify')->name('login.verify');
    Route::get('/register', 'register')->name('register.index');
    Route::post('/register', 'store')->name('register.store');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(NewspaperController::class)->group(function () {
    Route::get('/newspaper', 'index')->name('newsp.index');
    Route::post('/newspaper', 'store')->name('newsp.store');
    Route::put('/newspaper/{id}', 'update')->name('newsp.update');
    Route::delete('/newspaper/{id}', 'delete')->name('newsp.delete');
});

Route::get('/', function () {
    return redirect()->route('login.index');
});
