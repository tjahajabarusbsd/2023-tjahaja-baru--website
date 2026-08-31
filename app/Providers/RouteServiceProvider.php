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
        $this->configureRateLimiting();

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
        RateLimiter::for('global-api', function (Request $request) {
            $maxAttempts = app()->environment('local') ? 1000 : 60;

            return Limit::perMinute($maxAttempts)->by($request->ip());
        });

        RateLimiter::for('otp-send', function (Request $request) {
            $key = optional($request->user())->id
                ?? $request->input('new_phone_number')
                ?? $request->input('phone_number')
                ?? $request->input('email')
                ?? $request->ip();

            $formatRetryAfter = function (int $seconds) {
                if ($seconds >= 3600) {
                    $hours = ceil($seconds / 3600);
                    return $hours . ' jam';
                } elseif ($seconds >= 60) {
                    $minutes = ceil($seconds / 60);
                    return $minutes . ' menit';
                }
                return $seconds . ' detik';
            };

            return [
                Limit::perMinute(1)->by('otp-cooldown:' . $key)
                    ->response(function (Request $request, array $headers) use ($key, $formatRetryAfter) {
                        $retryAfter = (int) ($headers['Retry-After'] ?? 60);

                        Log::channel('otp_ratelimit')->warning('OTP rate limit: cooldown terkena', [
                            'key' => $key,
                            'ip' => $request->ip(),
                            'route' => $request->path(),
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Tunggu ' . $formatRetryAfter($retryAfter) . ' lagi sebelum meminta kode OTP.',
                            'data' => [
                                'retry_after' => $retryAfter,
                            ],
                        ], 429, $headers);
                    }),

                Limit::perDay(10)->by('otp-daily:' . $key)
                    ->response(function (Request $request, array $headers) use ($key, $formatRetryAfter) {
                        $retryAfter = (int) ($headers['Retry-After'] ?? 86400);

                        Log::channel('otp_ratelimit')->warning('OTP rate limit: kuota harian tercapai', [
                            'key' => $key,
                            'ip' => $request->ip(),
                            'route' => $request->path(),
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Batas permintaan OTP hari ini sudah tercapai. Coba lagi dalam ' . $formatRetryAfter($retryAfter) . '.',
                            'data' => [
                                'retry_after' => $retryAfter,
                            ],
                        ], 429, $headers);
                    }),

                Limit::perMinute(10)->by('otp-ip:' . $request->ip())
                    ->response(function (Request $request, array $headers) use ($key, $formatRetryAfter) {
                        $retryAfter = (int) ($headers['Retry-After'] ?? 60);

                        Log::channel('otp_ratelimit')->warning('OTP rate limit: limit per-IP terkena', [
                            'key' => $key,
                            'ip' => $request->ip(),
                            'route' => $request->path(),
                        ]);

                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak permintaan. Coba lagi dalam ' . $formatRetryAfter($retryAfter) . '.',
                            'data' => [
                                'retry_after' => $retryAfter,
                            ],
                        ], 429, $headers);
                    }),
            ];
        });
    }
}
