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

// Login
Route::middleware(['guest'])->group(function () {
    Route::get('/login',                 [LoginController::class, 'index'])->name('login');
    Route::post('/login',                [AjaxController::class, 'post_login']);
});

// Register
Route::prefix('register')->group(function () {
    Route::get('/',                      [RegisterController::class, 'index'])->name('register');
    Route::post('/step-one',             [AjaxController::class, 'post_register_step_one'])->middleware('guest')->name('register_step_one');
    Route::post('/step-two',             [AjaxController::class, 'post_register_step_two'])->middleware('auth')->name('register_step_two');
    Route::post('/step-three',           [AjaxController::class, 'post_register_step_three'])->middleware('auth')->name('register_step_three');
    Route::post('/step-four',            [AjaxController::class, 'post_register_step_four'])->middleware('auth')->name('register_step_four');
});

// Logged in / Completed registration
Route::middleware(['auth', 'profile.completed'])->group(function () {
    Route::get('/',                      [HomeController::class, 'index'])->name('home');

    Route::get('/profile',               [HomeController::class, 'profile'])->name('profile');
    Route::get('/applications',          [HomeController::class, 'applications'])->name('applications');
    Route::get('/logout',                [LoginController::class, 'logout'])->name('logout');

    Route::prefix('projects')->group(function () {
        Route::get('/',                  [HomeController::class, 'projects'])->name('projects');
        Route::get('/profile/{id}',      [HomeController::class, 'profile_show'])->name('profile.show');
        Route::get('/create',            [HomeController::class, 'project_create'])->name('project.create');
        Route::get('/edit/{id}',         [HomeController::class, 'project_edit'])->name('project.edit');
        Route::get('/{id}',              [HomeController::class, 'project_show'])->name('project.show');
    });
});
