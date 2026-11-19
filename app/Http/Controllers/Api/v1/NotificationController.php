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

    public function show(Request $request, $id)
    {
        $notification = Notification::where('user_public_id', $request->user()->id)
            ->where('id', $id)
            ->first();

        if (!$notification) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Notifikasi tidak ditemukan',
            ], 404);
        }

        $detail = null;

        switch ($notification->category) {

            case 'QR Scan':
                $qr = QrScanLog::with(['user', 'qrcode.promo.merchant'])
                    ->find($notification->source_id);

                if (!$qr) {
                    return $this->sourceNotFound();
                }

                $detail = [
                    'scan_id' => $qr->scan_code,
                    'merchant_name' => $qr->merchant_title,
                    'nama_qrcode' => optional(optional($qr->qrcode)->promo)->name,
                    'benefit' => optional($qr->qrcode)->benefit,
                    'user_name' => optional($qr->user)->name,
                    'usage_count' => $qr->usage_count,
                    'max_usage' => $qr->max_usage,
                    'scanned_at' => optional($qr->scanned_at)->format('d M Y H:i'),
                ];
                break;

            case 'Order Motor':
                $order = OrderMotor::find($notification->source_id);

                if (!$order) {
                    return $this->sourceNotFound();
                }

                $detail = [
                    'order_code' => $order->order_id,
                    'motor_name' => $order->model,
                    'warna' => $order->warna,
                    'tipe_pembayaran' => $order->tipe_pembayaran,
                    'status' => $order->status,
                    'ordered_at' => optional($order->created_at)->format('d M Y H:i'),
                ];
                break;

            case 'Booking Service':
                $booking = BookingService::with(['dealer', 'motor'])
                    ->find($notification->source_id);

                if (!$booking) {
                    return $this->sourceNotFound();
                }

                $detail = [
                    'booking_id' => $booking->id,
                    'booking_code' => $booking->booking_id,
                    'service_date' => $booking->tanggal,
                    'tanggal' => $booking->tanggal,
                    'jam' => $booking->jam,
                    'dealer' => optional($booking->dealer)->name_dealer,
                    'model' => optional($booking->motor)->nama_model,
                    'plat' => optional($booking->motor)->nomor_plat,
                    'status' => $booking->status,
                ];
                break;

            case 'Service Reminder':
                $booking = BookingService::with(['dealer', 'motor'])
                    ->find($notification->source_id);

                if (!$booking) {
                    return $this->sourceNotFound();
                }

                $detail = [
                    'booking_id' => $booking->id,
                    'booking_code' => $booking->booking_id,
                    'dealer' => optional($booking->dealer)->name_dealer,
                    'model' => optional($booking->motor)->nama_model,
                    'plat' => optional($booking->motor)->nomor_plat,
                    'tanggal' => $booking->tanggal,
                    'jam' => $booking->jam,
                    'status' => $booking->status,
                    'reminder_stage' => $notification->reminder_stage,
                    'reminder_stage_minutes' => is_numeric($notification->reminder_stage)
                        ? (int) $notification->reminder_stage
                        : null,
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
                'is_read' => (bool) $notification->is_read,
                'detail' => $detail
            ]
        ]);
    }

    /**
     * Notifikasi menunjuk ke data sumber yang sudah tidak ada
     * (mis. booking servis dihapus). Frontend menampilkan pesan ini
     * sebagai state kosong, bukan error 500.
     */
    private function sourceNotFound()
    {
        return response()->json([
            'status' => 'error',
            'code' => 404,
            'message' => 'Data terkait notifikasi ini sudah tidak tersedia',
        ], 404);
    }
}
