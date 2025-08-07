<?php

use App\Http\Controllers\Api\v1\ActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\BookingServiceController;
use App\Http\Controllers\Api\v1\EventController;
use App\Http\Controllers\Api\v1\LoyaltyTierController;
use App\Http\Controllers\Api\v1\MerchantController;
use App\Http\Controllers\Api\v1\MyMotorController;
use App\Http\Controllers\Api\v1\NotificationController;
use App\Http\Controllers\Api\v1\OtpController;
use App\Http\Controllers\Api\v1\RewardController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\VoucherController;

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
    Route::post('/products/order', [ProductController::class, 'order']); // nanti letakkan di middleware auth

    Route::middleware('throttle:60,1')->group(function () {
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::get('/merchants', [MerchantController::class, 'index']);
        Route::get('/merchants/{id}', [MerchantController::class, 'show']);
        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/{id}', [EventController::class, 'show']);
    });

    Route::middleware('auth:user_public')->group(function () {
        Route::get('/user', [UserController::class, 'getUser']);
        Route::get('/account/profile', [UserController::class, 'getAccount']);
        Route::post('/motor-registration', [MyMotorController::class, 'register']);
        Route::get('/user-motor', [MyMotorController::class, 'list']);
        Route::get('/services/{nomorRangka}/{svsId}', [MyMotorController::class, 'getRiwayatServis']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/activity', [ActivityController::class, 'index']);
        Route::get('/vouchers', [VoucherController::class, 'index']);
        Route::get('/voucher/{id}', [VoucherController::class, 'show']);
        Route::get('/rewards', [RewardController::class, 'index']);
        Route::get('/reward/{id}', [RewardController::class, 'show']);
        Route::get('/loyalty-tiers', [LoyaltyTierController::class, 'index']);
    });

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
    Route::post('/send-otp', [OtpController::class, 'sendOtp']);

    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/booking-servis', [BookingServiceController::class, 'store']);
});
