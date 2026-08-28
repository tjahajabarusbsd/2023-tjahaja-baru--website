<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('otp-send', function (Request $request) {
            $phone = $request->input('nomor_hp') ?? $request->input('email') ?? $request->ip();

            return [
                Limit::perMinute(1)->by('otp-cooldown:' . $phone)
                    ->response(function (Request $request, array $headers) use ($phone) {
                        Log::channel('otp_ratelimit')->warning('OTP rate limit: cooldown terkena', [
                            'phone' => $phone,
                            'ip' => $request->ip(),
                            'route' => $request->path(),
                        ]);

                        return response()->json([
                            'message' => 'Tunggu sebentar sebelum meminta kode OTP lagi.',
                        ], 429, $headers);
                    }),

                Limit::perDay(5)->by('otp-daily:' . $phone)
                    ->response(function (Request $request, array $headers) use ($phone) {
                        Log::channel('otp_ratelimit')->warning('OTP rate limit: kuota harian tercapai', [
                            'phone' => $phone,
                            'ip' => $request->ip(),
                            'route' => $request->path(),
                        ]);

                        return response()->json([
                            'message' => 'Batas permintaan OTP hari ini sudah tercapai. Coba lagi besok.',
                        ], 429, $headers);
                    }),

                Limit::perMinute(10)->by('otp-ip:' . $request->ip())
                    ->response(function (Request $request, array $headers) use ($phone) {
                        Log::channel('otp_ratelimit')->warning('OTP rate limit: limit per-IP terkena', [
                            'phone' => $phone,
                            'ip' => $request->ip(),
                            'route' => $request->path(),
                        ]);

                        return response()->json([
                            'message' => 'Terlalu banyak permintaan. Coba lagi sebentar lagi.',
                        ], 429, $headers);
                    }),
            ];
        });
    }
}
