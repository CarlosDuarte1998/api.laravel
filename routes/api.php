<?php

use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');



Route::apiResource('posts', PostController::class)->names('v1.posts');
Route::apiResource('category', CategoryController::class)->names('v1.category');