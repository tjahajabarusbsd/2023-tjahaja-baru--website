<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealerController;
use App\Http\Controllers\ExcelImportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VariantController;
use App\Http\Controllers\WhatsAppController;

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

Route::get('/', [HomeController::class, 'getData']);

Route::get('/myyamaha', function () {
    return view('myyamaha');
});

Route::get('/products', function () {
    return view('product/product');
});

Route::get('/products', [ProductController::class, 'getMaxi']);

Route::prefix('/products/category')->group(function () {
    Route::get('{uri}', [ProductController::class, 'getCategory']);
});

Route::prefix('/product')->group(function () {
    Route::get('{uri}', [VariantController::class, 'getDataVariant']);
});

Route::get('/get-data/{variant}', [VariantController::class, 'getData'])->name('get.data');

Route::get('/dealers', [DealerController::class, 'getDealer'])->name('dealer');

Route::get('/consultation', [ConsultationController::class, 'getConsultationForm'])->name('consultation.get');

Route::get('/contact', [ContactController::class, 'getContactForm'])->name('contact.get');
Route::post('/contact', [ContactController::class, 'submitContactForm'])->name('contact.submit');

Route::post('/send_message', [WhatsAppController::class, 'sendMessage']);

Route::get('/compare_product', [ComparisonController::class, 'specComparison']);
Route::get('/get_spec_details/{id}', [ComparisonController::class, 'getSpecDetails']);

// Route::get('/import-xls', function () {
//     return view('import');
// });
// Route::post('/import', [ExcelImportController::class, 'import'])->name('import');
// Route::post('/import-dealer', [ExcelImportController::class, 'importDealer'])->name('importDealer');
// Route::post('/import-spec', [ExcelImportController::class, 'importSpec'])->name('importSpec');

// Route::prefix('/news')->group(function () {
//     Route::get('{uri}', 'ArticleController@detail');
// });
// Route::get('/news', [ArticleController::class, 'loadmore']);

// Route::post('/contact', [ContactController::class, 'postContactForm'])->name('contact.post');

// Route::post('/consultation', [ConsultationController::class, 'postConsultationForm'])->name('consultation.post');

// Route::prefix('/product')->group(function () {
//     Route::get('{uri}/{name}', [VariantController::class, 'getGroup']);
// });

// Route::post('/product', [ConsultationController::class, 'postConsultationForm'])->name('consultationProduct.post');

// Route::get('/dealers', [VariantController::class, 'getRandomProduct']);