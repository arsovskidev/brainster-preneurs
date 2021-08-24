<?php

use App\Http\Controllers\Auth\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
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


Route::middleware(['guest'])->group(function () {
    Route::get('/login',       [LoginController::class, 'index'])->name('login');
    Route::post('/login',      [AjaxController::class, 'post_login']);
});

Route::prefix('register')->group(function () {
    Route::get('/',            [RegisterController::class, 'index'])->name('register');
    Route::post('/step-one',   [AjaxController::class, 'post_register_step_one'])->middleware('guest')->name('register_step_one');
    Route::post('/step-two',   [AjaxController::class, 'post_register_step_two'])->middleware('auth')->name('register_step_two');
    Route::post('/step-three', [AjaxController::class, 'post_register_step_three'])->middleware('auth')->name('register_step_three');
    Route::post('/step-four',  [AjaxController::class, 'post_register_step_four'])->middleware('auth')->name('register_step_four');
});

Route::middleware(['auth', 'profile.completed'])->group(function () {
    Route::get('/',             [HomeController::class, 'index'])->name('home');
    Route::get('/profile',      [HomeController::class, 'profile'])->name('profile');
    Route::get('/projects',     [HomeController::class, 'projects'])->name('projects');
    Route::get('/applications', [HomeController::class, 'applications'])->name('applications');
    Route::get('/logout',       [LoginController::class, 'logout'])->name('logout');
});
