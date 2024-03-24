<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('users', [UserController::class, 'register']);
Route::post('users/login', [UserController::class, 'login']);

Route::middleware(ApiAuthMiddleware::class)->group(function () {
    Route::get('users/current', [UserController::class, 'get']);
    Route::patch('users/current', [UserController::class, 'update']);
    Route::delete('users/logout', [UserController::class, 'logout']);

    Route::post('contacts', [ContactController::class, 'create']);
    Route::get('contacts', [ContactController::class, 'search']);
    Route::get('contacts/{id}', [ContactController::class, 'get']);
    Route::put('contacts/{id}', [ContactController::class, 'update']);
    Route::delete('contacts/{id}', [ContactController::class, 'delete']);

    Route::post('contacts/{idContact}/addresses', [AddressController::class, 'create']);
    Route::get('contacts/{idContact}/addresses/{idAddress}', [AddressController::class, 'get']);
    Route::put('contacts/{idContact}/addresses/{idAddress}', [AddressController::class, 'update']);
});
