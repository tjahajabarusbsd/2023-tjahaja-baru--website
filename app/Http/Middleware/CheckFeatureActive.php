<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use App\Models\FeatureStatus;
use Closure;
use Illuminate\Http\Request;

class CheckFeatureActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $feature)
    {
        $status = FeatureStatus::where('key', $feature)->first();

        // key tidak ada di tabel = dianggap aktif (fail-open)
        if ($status && ! $status->is_active) {
            return ApiResponse::error(
                $status->maintenance_message ?? 'Fitur sedang maintenance',
                503,
                [
                    'error_code' => 'FEATURE_MAINTENANCE',
                    'feature'    => $status->key,
                    'until'      => $status->maintenance_until?->toIso8601String(),
                ]
            );
        }

        return $next($request);
    }
}
