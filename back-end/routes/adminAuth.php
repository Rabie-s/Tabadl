<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;



Route::post('admin/register',[AuthController::class,'register']);

Route::post('admin/login',[AuthController::class,'login'])->middleware('guest');

Route::post('admin/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum','type.admin']);

Route::middleware(['auth:sanctum','type.admin'])->get('admin/info', function (Request $request) {
    return 'test';
});
