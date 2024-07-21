<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;

Route::post('/register', [UserAuthController::class, 'register'])
    ->middleware('guest')
    ->name('register');


Route::post('/login', [UserAuthController::class, 'login'])
    ->middleware('guest')
    ->name('login');


Route::post('/logout', [UserAuthController::class, 'logout'])
    ->middleware('auth:sanctum')
    ->name('logout');
