<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('register', RegisterController::class);
Route::apiResource('category', CategoryController::class)->names('api.v1.category');