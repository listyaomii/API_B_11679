<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JadwalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::get('/', [UserController::class, 'profile']);
Route::put('/update', [UserController::class, 'update']);
Route::delete('/delete', [UserController::class, 'destroy']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    // Peserta Routes
    Route::get('/peserta', [PesertaController::class, 'index']);
    Route::post('peserta/create', [PesertaController::class, 'store']);
    Route::put('peserta/update/{id}', [PesertaController::class, 'update']);  
    Route::delete('peserta/delete/{id}', [PesertaController::class, 'destroy']);  

    // Event Routes
    Route::get('/event', [EventController::class, 'index']);
    Route::post('event/create', [EventController::class, 'store']);
    Route::put('event/update/{id}', [EventController::class, 'update']); 
    Route::post('event/search', [EventController::class, 'search']); 
    Route::delete('event/delete/{id}', [EventController::class, 'destroy']);  

    Route::get('/jadwal', [JadwalController::class, 'index']);
    Route::post('jadwal/create', [JadwalController::class, 'store']);
    Route::put('jadwal/update/{id}', [JadwalController::class, 'update']); 
    Route::post('jadwal/search', [JadwalController::class, 'search']); 
    Route::delete('jadwal/delete/{id}', [JadwalController::class, 'destroy']);  

    // Logout Route
    Route::post('/logout', [UserController::class, 'logout']);
});

