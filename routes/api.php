<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AuthController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register'])->name('v1.register'); 
Route::post('login',[AuthController::class, 'login'])->name('v1.login');



Route::middleware('auth:sanctum')->group(function () {
    Route::get('logout', [AuthController::class, 'logout'])->name('v1.logout');
    Route::apiResource('posts', PostController::class)->names('v1.posts');
    Route::apiResource('category', CategoryController::class)->names('v1.category');
});