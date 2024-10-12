<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    //admin routs
    Route::prefix('admin')->group(function () {

        require __DIR__ . '/api/v1/adminAuthApi.php';
        require __DIR__ . '/api/v1/adminApi.php';
    });

    //user routs
    Route::prefix('user')->group(function () {

        require __DIR__ . '/api/v1/userAuthApi.php';
        require __DIR__ . '/api/v1/booksAbi.php';
    });
});
