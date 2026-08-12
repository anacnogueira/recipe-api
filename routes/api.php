<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('users', UserController::class)->except(['store']);

        Route::apiResource('recipes', RecipeController::class);
        Route::patch('/recipes/{recipe}/image', [RecipeController::class, 'uploadImage']);
        Route::post('/recipes/{recipe}/react', [ReactionController::class, 'react']);
    });
});
