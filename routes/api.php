<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt.auth')->prefix('animal')->group(function() {
    Route::get('/', [App\Http\Controllers\AnimalController::class, 'index']);
    Route::get('/search', [App\Http\Controllers\AnimalController::class, 'search']);
    Route::post('/create', [App\Http\Controllers\AnimalController::class, 'create']);
    Route::put('/update/{animal}', [App\Http\Controllers\AnimalController::class, 'update']);
    Route::delete('/delete/{animal}', [App\Http\Controllers\AnimalController::class, 'delete']);
});

Route::middleware('jwt.auth')->group(function() {
    Route::post('/refresh', [App\Http\Controllers\AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [App\Http\Controllers\AuthController::class, 'me']);
    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout']);
});

Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
