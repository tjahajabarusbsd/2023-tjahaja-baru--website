<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\BookingService;
use App\Models\Notification;
use App\Models\OrderMotor;
use App\Models\QrScanLog;
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

    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        $detail = null;

        switch ($notification->category) {

            case 'QR Scan':
                $qr = QrScanLog::findOrFail($notification->source_id);

                $detail = [
                    'scan_id' => $qr->scan_code,
                    'merchant_name' => $qr->qrcode->merchant->title,
                    'nama_qrcode' => $qr->qrcode->nama_qrcode,
                    'benefit' => $qr->qrcode->benefit,
                    'user_name' => $qr->user->name,
                    'usage_count' => $qr->usage_count,
                    'max_usage' => $qr->max_usage,
                    'scanned_at' => $qr->scanned_at->format('d M Y H:i'),
                ];
                break;

            case 'Order Motor':
                $order = OrderMotor::findOrFail($notification->source_id);

                $detail = [
                    'order_code' => $order->order_id,
                    'motor_name' => $order->model,
                    'warna' => $order->warna,
                    'tipe_pembayaran' => $order->tipe_pembayaran,
                    'status' => $order->status,
                    'ordered_at' => $order->created_at->format('d M Y H:i'),
                ];
                break;

            case 'Booking Service':
                $booking = BookingService::findOrFail($notification->source_id);

                $detail = [
                    'booking_code' => $booking->booking_code,
                    'service_date' => $booking->service_date,
                    'points' => $booking->points,
                    'status' => $booking->status,
                ];
                break;

            default:
                return response()->json([
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'Kategori tidak dikenali'
                ], 400);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Detail notifikasi berhasil dimuat',
            'data' => [
                'notification_id' => $notification->id,
                'title' => $notification->title,
                'category' => $notification->category,
                'time' => $notification->created_at->format('d M Y H:i'),
                'is_read' => $notification->is_read,
                'detail' => $detail
            ]
        ]);
    }

}
