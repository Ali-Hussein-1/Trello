<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\UserController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('me', 'me');
});

Route::controller(UserController::class)->group(function() {
    Route::get('get_boards', 'get_boards');
});

Route::controller(BoardController::class)->group(function (){
    Route::post('create', 'create');
    Route::post('delete', 'delete');
    Route::get('get_categories', 'get_categories');
    Route::get('get_users', 'get_users');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});