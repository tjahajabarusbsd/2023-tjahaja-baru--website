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
        $user = $request->user(); // user_public yang login via guard

        $notifications = Notification::where('user_public_id', $user->id)
            ->latest()
            ->paginate(10);

        Notification::where('user_public_id', $user->id)
            ->where('is_read', 0)
            ->update(['is_read' => 1]);

        return NotificationResource::collection($notifications)
            ->additional([
                'status' => 'success',
                'code' => 200,
                'message' => 'Daftar notifikasi berhasil dimuat',
            ]);
    }
}
