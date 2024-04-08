<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// --- Page Section --- 
Route::get('/', [HomeController::class, 'getData'])->name('home');
Route::get('/dealers', [DealerController::class, 'getDealer']);
Route::get('/profile', function () { return view('/about-us'); });
Route::get('/myyamaha', function () { return view('myyamaha'); });
// --- End Page Section --- 

// --- Product Section --- 
Route::get('/products', [ProductController::class, 'getMaxi']);

Route::prefix('/products/category')->group(function () {
    Route::get('{uri}', [ProductController::class, 'getCategory']);
});

Route::prefix('/product')->group(function () {
    Route::get('{uri}', [VariantController::class, 'getDataVariant']);
});

Route::get('/get-data/{variant}', [VariantController::class, 'getData'])->name('get.data');
// --- End Product Section --- 

// --- Contact Section --- 
Route::get('/contact', [ContactController::class, 'getContactForm'])->name('contact.get');
Route::post('/contact', [ContactController::class, 'submitContactForm'])->name('contact.submit');
// --- End Contact Section --- 

// --- Consultation Section --- 
Route::get('/consultation', [ConsultationController::class, 'getConsultationForm']);
Route::post('/send_message', [WhatsAppController::class, 'sendMessage']);
// --- End Consultation Section --- 

// --- Comparison Section --- 
Route::get('/compare_product', [ComparisonController::class, 'specComparison']);
Route::get('/get_spec_details/{id}', [ComparisonController::class, 'getSpecDetails']);
// --- End Comparison Section --- 

// --- Personality Quiz Section
Route::get('/kuis', function () { return view('/quiz'); });
Route::post('/submit-quiz/', [PersonalityController::class, 'submitQuiz']);
// --- End Personality Quiz Section

// --- Import File Section
Route::get('/import-xls', function () {
    return view('import');
});
Route::post('/import', [ExcelImportController::class, 'import'])->name('import');
Route::post('/import-dealer', [ExcelImportController::class, 'importDealer'])->name('importDealer');
Route::post('/import-spec', [ExcelImportController::class, 'importSpec'])->name('importSpec');
// --- End Import File Section

/*
Route::middleware('auth')->group(function () {
    Route::get('/user-profile', [UserProfileController::class, 'getUserProfile'])->name('user.profile');
    Route::post('/user-profile/save-no-rangka', [UserProfileController::class, 'saveNoRangka'])->name('user.profile.saveNoRangka');
    Route::post('/update-profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/riwayatservis/cetak_pdf', [UserProfileController::class, 'cetakPdf']);
});

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm']);
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendLinkResetPassword'])->name('send.link');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'resetPasswordForm'])->name('reset.password.form');
    Route::post('reset-password-update', [ResetPasswordController::class, 'updatePassword'])->name('reset.password.update');
});

Route::middleware(['web'])->group(function () {
    Route::get('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::get('/auth/redirect', [LoginController::class, 'redirectToGoogle']);

Route::get('/auth/callback', [LoginController::class, 'handleGoogleCallback']);
*/