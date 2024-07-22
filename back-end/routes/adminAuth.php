<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;



Route::post('admin/register', [AuthController::class, 'register']);

Route::post('admin/login', [AuthController::class, 'login'])->middleware('guest');

Route::post('admin/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum', 'type.admin']);

Route::get('admin/fetchAdmins', [AuthController::class, 'fetchAdmins'])->middleware(['auth:sanctum', 'type.admin']);

Route::delete('admin/deleteAdmin/{id}',[AuthController::class, 'deleteAdmin'])->middleware(['auth:sanctum', 'type.admin']);

