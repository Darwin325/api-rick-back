<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('favorites', \App\Http\Controllers\FavoriteController::class)->only([
        'index', 'store', 'destroy'
    ]);

    Route::get('me', [\App\Http\Controllers\UserController::class, 'me']);
    Route::put('update/me', [\App\Http\Controllers\UserController::class, 'updateMe']);

    Route::get('favorites/user', [\App\Http\Controllers\FavoriteController::class, 'getFavoritesByUser']);
    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
