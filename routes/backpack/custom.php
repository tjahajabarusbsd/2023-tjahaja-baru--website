<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    // 'middleware' => ['web','can:can_manage_content'],
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::group([
        'middleware' => ['can:can_manage_menu_website'],
    ], function () {
        Route::crud('category', 'CategoryCrudController');
        Route::crud('group', 'GroupCrudController');
        Route::crud('variant', 'VariantCrudController');
        Route::crud('banner', 'BannerCrudController');
        Route::crud('promo', 'PromoCrudController');
        Route::crud('contact', 'ContactCrudController');
        Route::crud('dealer', 'DealerCrudController');
        Route::crud('review', 'ReviewCrudController');
        Route::crud('group-product-spec', 'GroupProductSpecCrudController');
        Route::crud('consultation', 'ConsultationCrudController');
    });

    Route::group([
        'middleware' => ['can:can_manage_menu_mobile'],
    ], function () {
        Route::crud('nomor-rangka', 'NomorRangkaCrudController');
        Route::crud('booking-service', 'BookingServiceCrudController');
        Route::crud('event', 'EventCrudController');
        Route::crud('order-motor', 'OrderMotorCrudController');
        Route::crud('merchant', 'MerchantCrudController');
        Route::crud('reward', 'RewardCrudController');
    });
}); // this should be the absolute last line of this file