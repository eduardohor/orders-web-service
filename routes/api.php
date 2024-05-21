<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Middleware\ThrottleLoginAttempts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->middleware(ThrottleLoginAttempts::class);
