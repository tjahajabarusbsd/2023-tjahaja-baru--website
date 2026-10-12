<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\FeatureStatus;
use App\Helpers\ApiResponse;

class AppConfigController extends Controller
{
    public function index()
    {
        $features = FeatureStatus::query()
            ->get(['key', 'is_active', 'maintenance_message', 'maintenance_until'])
            ->map(fn(FeatureStatus $f) => [
                'key'       => $f->key,
                'is_active' => $f->is_active,
                'message'   => $f->maintenance_message,
                'until'     => $f->maintenance_until?->toIso8601String(),
            ])
            ->values();

        return ApiResponse::success('OK', ['features' => $features]);
    }
}
