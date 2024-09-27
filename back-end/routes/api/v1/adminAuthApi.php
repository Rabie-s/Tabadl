<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;



Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:admin-api');
    Route::post('refreshToken', [AuthController::class, 'refreshToken'])->middleware('auth:admin-api');
    Route::post('adminInfo', [AuthController::class, 'adminInfo'])->middleware('auth:admin-api');
    Route::post('deleteAdminProfile/{id}', [AuthController::class, 'deleteAdminProfile'])->middleware('auth:admin-api');
});