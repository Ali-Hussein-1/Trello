<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});

Route::controller(BoardController::class)->group(function (){
    Route::post('create', 'create');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});