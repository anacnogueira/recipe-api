<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::name('api.')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
});
