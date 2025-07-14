<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\MyMotorController;
use App\Http\Controllers\Api\v1\UserController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class, 'index']); // public
    Route::get('/products/{id}', [ProductController::class, 'show']); // public
    Route::post('/products/order', [ProductController::class, 'order']); // nanti letakkan di middleware auth
    Route::post('/motor-registration', [MyMotorController::class, 'register']); // nanti letakkan di middleware auth
    Route::get('/user-motor', [MyMotorController::class, 'list']); // nanti letakkan di middleware auth

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [UserController::class, 'profile']);
    });

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});