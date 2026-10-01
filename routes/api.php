<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;

// Authentification API par jeton pour les clients et négociants.
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

// Les routes ci-dessous exigent un jeton Sanctum valide.
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profil', [AuthApiController::class, 'profil']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
});