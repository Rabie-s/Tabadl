<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\AuthController;



Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refreshToken', [AuthController::class, 'refreshToken'])->middleware('auth:user-api');
    Route::post('userInfo', [AuthController::class, 'userInfo'])->middleware('auth:user-api');
    Route::post('deleteUserProfile/{id}', [AuthController::class, 'deleteUserProfile'])->middleware('auth:user-api');

});