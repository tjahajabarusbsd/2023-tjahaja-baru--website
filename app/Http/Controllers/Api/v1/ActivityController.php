<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Models\ActivityLog;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil log dari database untuk user ini
        $activityLogs = ActivityLog::where('user_public_id', $user->id)
            ->orderBy('activity_date', 'desc')
            ->get()
            ->map(function ($log) {
                return [
                    'id'          => $log->id,
                    'type'        => $log->type,
                    'title'       => $log->title,
                    'description' => $log->description ?? '',
                    'date' => $log->activity_date
                        ? \Carbon\Carbon::parse($log->activity_date)->format('d M Y')
                        : null,
                    'points'      => $log->points > 0
                        ? '+' . $log->points
                        : (string) $log->points
                ];
            });

        return ApiResponse::success('Daftar aktivitas berhasil diambil.', $activityLogs);
    }
}
