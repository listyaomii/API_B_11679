<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Peserta Routes
    Route::get('/peserta', [PesertaController::class, 'index']);
    Route::post('peserta/create', [PesertaController::class, 'store']);
    Route::post('peserta/update/{id}', [PesertaController::class, 'update']);  
    Route::post('peserta/delete/{id}', [PesertaController::class, 'destroy']);  

    // Event Routes
    Route::get('/event', [EventController::class, 'index']);
    Route::post('event/create', [EventController::class, 'store']);
    Route::post('event/update/{id}', [EventController::class, 'update']); 
    Route::post('event/delete/{id}', [EventController::class, 'destroy']);  

    // Logout Route
    Route::post('/logout', [UserController::class, 'logout']);
});

