<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set timezone sesuai config/app.php
        date_default_timezone_set(config('app.timezone'));

        // Set locale Carbon ke bahasa Indonesia
        Carbon::setLocale('id');
    }
}
