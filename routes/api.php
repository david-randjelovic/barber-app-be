<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReservationController;

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

Route::post('auth/register-client', [AuthController::class, 'registerClient']);
Route::post('auth/login', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->group( function () {
    Route::get('posts', [PostController::class, 'index']);
    Route::post('upload-post', [PostController::class, 'store']);
    Route::get('user-data', [UserController::class, 'getUsersData']);
    Route::get('reservations', [ReservationController::class, 'index']);
    Route::post('create-reservation', [ReservationController::class, 'store']);
});
