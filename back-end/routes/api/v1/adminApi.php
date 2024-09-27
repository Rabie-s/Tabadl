<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('fetchBooksWithUsers', [AdminController::class, 'fetchBooksWithUsers'])->middleware('auth:admin-api');

Route::get('fetchUsers', [AdminController::class, 'fetchUsers'])->middleware('auth:admin-api');

Route::delete('deleteBook/{id}', [AdminController::class, 'deleteBook'])->middleware('auth:admin-api');

Route::get('fetchAdmins', [AdminController::class, 'fetchAdmins'])->middleware('auth:admin-api');

Route::delete('deleteAdmin/{id}', [AdminController::class, 'deleteAdmin'])->middleware('auth:admin-api');
