<?php

use App\Http\Controllers\Api\v1\ActivityController;
use App\Http\Controllers\Api\v1\PromoController;
use App\Http\Controllers\Api\v1\QrScanController;
use App\Http\Controllers\Api\v1\QrScanLogController;
use App\Http\Controllers\Api\v1\RewardClaimController;
use App\Http\Controllers\VoucherScanLogController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\BookingServiceController;
use App\Http\Controllers\Api\v1\DealerController;
use App\Http\Controllers\Api\v1\EventController;
use App\Http\Controllers\Api\v1\LoyaltyTierController;
use App\Http\Controllers\Api\v1\MerchantController;
use App\Http\Controllers\Api\v1\MyMotorController;
use App\Http\Controllers\Api\v1\NotificationController;
use App\Http\Controllers\Api\v1\OnboardingController;
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
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login/google', [AuthController::class, 'loginGoogle']);
    Route::post('/login/facebook', [AuthController::class, 'loginFacebook']);
    Route::post('/verify-otp', [OtpController::class, 'verifyOtp']);
    Route::post('/send-otp', [OtpController::class, 'sendOtp']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);

    Route::post('/login-merchant', [AuthController::class, 'loginMerchant']);

    Route::middleware('throttle:60,1')->group(function () {
        Route::get('/onboarding', [OnboardingController::class, 'index']);
        Route::get('/products', [ProductController::class, 'index']);
        Route::get('/products/{id}', [ProductController::class, 'show']);
        Route::get('/merchants', [MerchantController::class, 'index']);
        Route::get('/merchant/{id}', [MerchantController::class, 'show']);
        Route::get('/rewards', [RewardController::class, 'index']);
        Route::get('/reward/{id}', [RewardController::class, 'show']);
        Route::get('/events', [EventController::class, 'index']);
        Route::get('/events/{id}', [EventController::class, 'show']);
        Route::get('/dealers', [DealerController::class, 'index']);
        Route::get('/promos/banner', [PromoController::class, 'index']);
    });

    Route::middleware('auth:user_public')->group(function () {
        Route::post('/update-fcm-token', [AuthController::class, 'updateFcmToken']);

        // Profile & Account Management
        Route::get('/user', [UserController::class, 'getUser']);
        Route::get('/account/profile', [UserController::class, 'getAccount']);
        Route::post('/account/profile/edit', [UserController::class, 'editProfile']);
        Route::post('/account/profile/ganti-password', [UserController::class, 'changePassword']);
        Route::post('/account/request-ganti-nomor-hp', [UserController::class, 'requestChangeNomorHp'])->middleware('throttle:10,1');
        Route::post('/account/verify-ganti-nomor-hp', [UserController::class, 'verifyChangeNomorHp']);
        Route::post('/account/otp-resend-ganti-nomor-hp', [UserController::class, 'otpResendChangeNumber'])->middleware('throttle:10,1');
        Route::post('/logout', [AuthController::class, 'logout']);

        // My Motor
        Route::get('/user-motor', [MyMotorController::class, 'list']);
        Route::get('/services/{nomorRangka}/{svsId}', [MyMotorController::class, 'getRiwayatServis']);
        Route::post('/motor-registration', [MyMotorController::class, 'register']);
        Route::post('/products/order', [ProductController::class, 'order']);

        // Booking Servis
        Route::get('/booking-servis/status', [BookingServiceController::class, 'index']);
        Route::post('/booking-servis', [BookingServiceController::class, 'store']);
        Route::post('/booking-servis/batal', [BookingServiceController::class, 'batal']);

        // QR Scan
        Route::post('/qr/scan', [QrScanController::class, 'scan']);
        Route::post('/qr/redeem', [QrScanController::class, 'manualInput']);

        // Rewards
        Route::get('/reward-claims', [RewardClaimController::class, 'index']);
        Route::post('/reward/{id}/claim', [RewardController::class, 'store']);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
        Route::get('/notifications/{id}', [NotificationController::class, 'show']);
        Route::get('/activity', [ActivityController::class, 'index']);
        Route::get('/vouchers', [VoucherController::class, 'index']);
        Route::get('/voucher/{id}', [RewardClaimController::class, 'show']);
        Route::get('/loyalty-tiers', [LoyaltyTierController::class, 'index']);

        Route::get('/qr-scan-logs/{id}', [QrScanLogController::class, 'show']);
    });

    Route::middleware('auth:user_merchant')->group(function () {
        Route::get('/voucher-scans', [VoucherScanLogController::class, 'index']);
        Route::post('/voucher-scans', [VoucherScanLogController::class, 'store']);
    });
});