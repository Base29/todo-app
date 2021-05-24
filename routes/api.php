<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoItemController;
use App\Http\Controllers\VerificationController;

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
    // Route for user login
    Route::post('login', [AuthController::class, 'login']);

    // Route for verifying JWT token
    Route::post('checktoken', [AuthController::class, 'checkToken']);

    // Route for logout
    Route::post('logout', [AuthController::class, 'logout']);

    // Route for user register
    Route::post('register', [AuthController::class, 'register']);

    // Route for fetching todo items
    Route::get('items', [TodoItemController::class, 'index']);

    // Route for creating a todo item
    Route::post('item', [TodoItemController::class, 'create']);

    // Route for updating a todo item
    Route::put('item/{id}', [TodoItemController::class, 'update']);

    // Route for deleting a todo item
    Route::delete('item/{id}', [TodoItemController::class, 'delete']);

    // Route for fetching a single todo item
    Route::get('item/{id}', [TodoItemController::class, 'singleItem']);

    // Route for marking a todo item as done
    Route::put('done/{id}', [TodoItemController::class, 'done']);

    // Route for verifying user email
    Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
});