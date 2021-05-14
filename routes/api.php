<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoItemController;

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

Route::group(['namespace' => 'Api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('checktoken', [AuthController::class, 'checkToken']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('items', [TodoItemController::class, 'index']);
    Route::post('items', [TodoItemController::class, 'create']);
    Route::put('item/{id}', [TodoItemController::class, 'update']);
    Route::delete('item/{id}', [TodoItemController::class, 'delete']);
});