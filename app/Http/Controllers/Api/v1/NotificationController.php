<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * List semua notifikasi user (auth:user_public)
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Notification::where('user_public_id', $user->id);

        /**
         * =========================
         * FILTER CATEGORY
         * =========================
         */
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        /**
         * =========================
         * FILTER MONTH (format: YYYY-MM)
         * =========================
         */
        if ($request->filled('month')) {
            try {
                $date = \Carbon\Carbon::createFromFormat('Y-m', $request->month);

                $query->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'code' => 422,
                    'message' => 'Format month harus YYYY-MM',
                ], 422);
            }
        }

        /**
         * =========================
         * PAGINATION
         * =========================
         */
        $notifications = $query
            ->latest()
            ->paginate(10);

        return NotificationResource::collection($notifications)
            ->additional([
                'status' => 'success',
                'code' => 200,
                'message' => 'Daftar notifikasi berhasil dimuat',
            ]);
    }

    public function unreadCount(Request $request)
    {
        $user = $request->user();

        $count = Notification::where('user_public_id', $user->id)
            ->where('is_read', 0)
            ->count();

        return response()->json([
            'unread_count' => $count,
        ]);
    }

    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();

        $notification = Notification::where('user_public_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $notification->update([
            'is_read' => 1,
            'read_at' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Notifikasi berhasil ditandai sebagai dibaca',
        ]);
    }
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        Notification::where('user_public_id', $user->id)
            ->where('is_read', 0)
            ->update([
                'is_read' => 1,
            ]);

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Semua notifikasi ditandai sebagai dibaca',
        ]);
    }

}
