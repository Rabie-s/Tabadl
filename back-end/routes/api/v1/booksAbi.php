<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\BookController;

Route::get('userBooks', [BookController::class, 'showUserBooks'])->middleware('auth:user-api');;
Route::put('completed', [BookController::class, 'completed'])->middleware('auth:user-api');;
Route::resource('books', BookController::class);