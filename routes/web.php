<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::get('/register',    [RegisterController::class, 'index'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login',       [LoginController::class, 'index'])->name('login');
});
