<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    // authcontroller api
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/user-detail', [AuthController::class, 'userDetail'])->middleware('auth:api')->name('user-detail');

    // postcontroller api
    Route::post('/create-post', [PostController::class, 'createPost'])->middleware('auth:api')->name('create-post');
});
