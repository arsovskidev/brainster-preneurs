<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AcademyController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AjaxController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'profile.completed', 'throttle:60,1']], function () {
    Route::get('/academies',                                      [AcademyController::class, 'index']);
    Route::get('/projects',                                       [ProjectController::class, 'index']);
    Route::get('/projects/academy/{id}',                          [ProjectController::class, 'filter']);

    Route::get('/account/projects',                               [ProjectController::class, 'account_projects']);
    Route::get('/account/applications',                           [ApplicationController::class, 'account_applications']);

    Route::post('/project/create',                                [ProjectController::class, 'create']);
    Route::put('/project/edit/{id}',                              [ProjectController::class, 'edit']);
    Route::delete('/project/delete/{id}',                         [ProjectController::class, 'destroy']);


    Route::post('/project/apply/{id}',                            [ApplicationController::class, 'apply']);
    Route::get('/project/cancel/{id}',                            [ApplicationController::class, 'cancel']);

    Route::get('/project/{project_id}/accept/{applicant_id}',     [ApplicationController::class, 'accept']);
    Route::get('/project/{id}/start',                             [ProjectController::class, 'start']);


    Route::post('/profile/edit',                                   [UserController::class, 'edit']);
});
