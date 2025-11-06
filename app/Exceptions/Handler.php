<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Helpers\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        // 2. Tambahkan blok logika ini di dalam method render
        if ($exception instanceof ThrottleRequestsException) {
            // Ambil informasi 'Retry-After' dari header exception
            $retryAfter = $exception->getHeaders()['Retry-After'] ?? 60; // Default 60 detik jika tidak ada

            // Kembalikan response menggunakan format ApiResponse Anda
            // Ini akan membuat response konsisten dengan endpoint lainnya
            return response()->json([
                'success' => false, // Sesuaikan dengan struktur ApiResponse Anda
                'message' => 'Terlalu banyak percobaan. Silakan tunggu ' . $retryAfter . ' detik lagi.',
                'data' => [
                    'retry_after' => (int) $retryAfter
                ]
            ], 429); // Status HTTP 429 Too Many Requests
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Kalau request mengharapkan JSON (API)
        if ($request->expectsJson() || $request->is('api/*')) {
            return ApiResponse::error('Unauthorized', 401);
        }

        // Kalau request web biasa, tetap redirect ke login
        return redirect()->guest(route('login'));
    }
}