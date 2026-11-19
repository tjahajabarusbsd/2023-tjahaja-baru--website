<?php

namespace App\Services\Booking;

use App\Models\BookingService;
use App\Models\Notification;
use App\Services\Notification\FcmService;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Pengingat servis: mengirim notifikasi 60, 30, dan 15 menit
 * sebelum jam booking servis yang berstatus "confirmed".
 *
 * Alur:
 * 1. Ambil booking_services status = confirmed dengan tanggal = hari ini.
 * 2. Hitung waktu booking dari kolom tanggal + jam.
 * 3. Untuk setiap tahap (60/30/15), kirim bila waktu sekarang sudah
 *    melewati (waktu booking - tahap) dan masih dalam toleransi.
 * 4. Simpan ke tabel notifications + kirim FCM.
 */
class ServiceReminderService
{
    public const CATEGORY = 'Service Reminder';

    /** Tahap pengingat dalam menit sebelum jam booking. */
    public const STAGES = [60, 30, 15];

    /**
     * Toleransi keterlambatan scheduler (menit).
     *
     * WAJIB lebih besar dari interval schedule `booking:service-reminder`
     * (everyFiveMinutes). Dengan interval 5 menit, target pengingat bisa
     * terlewat maksimal ~5 menit, jadi 6 menit memberi sisa 1 menit untuk
     * jitter server. Kalau interval diubah, ubah nilai ini juga.
     */
    public const GRACE_MINUTES = 6;

    public function __construct(private FcmService $fcm)
    {
    }

    /**
     * Kirim semua pengingat yang jatuh tempo.
     *
     * @param  int|null  $userId  Batasi ke satu user (null = semua user).
     * @return array<int, array<string, mixed>> Daftar pengingat yang terkirim.
     */
    public function sendDueReminders(?int $userId = null): array
    {
        $now = Carbon::now();
        $sent = [];

        $bookings = BookingService::with(['user', 'motor', 'dealer'])
            ->where('status', 'confirmed')
            ->whereDate('tanggal', $now->toDateString())
            ->when($userId !== null, fn ($query) => $query->where('user_id', $userId))
            ->get();

        foreach ($bookings as $booking) {
            $bookingAt = $this->bookingDateTime($booking);

            // Booking yang jamnya sudah lewat / data tidak valid dilewati.
            if (!$bookingAt || $bookingAt->lessThanOrEqualTo($now)) {
                continue;
            }

            foreach (self::STAGES as $stage) {
                $remindAt = $bookingAt->copy()->subMinutes($stage);

                // Belum waktunya.
                if ($now->lessThan($remindAt)) {
                    continue;
                }

                // Sudah lewat dari batas toleransi (mis. scheduler sempat mati).
                if ($now->greaterThan($remindAt->copy()->addMinutes(self::GRACE_MINUTES))) {
                    continue;
                }

                if ($this->alreadySent($booking, $stage)) {
                    continue;
                }

                if ($this->send($booking, $stage, $bookingAt)) {
                    $sent[] = [
                        'booking_id' => $booking->id,
                        'booking_code' => $booking->booking_id,
                        'user_public_id' => $booking->user_id,
                        'stage_minutes' => $stage,
                        'remind_at' => $remindAt->toIso8601String(),
                        'booking_at' => $bookingAt->toIso8601String(),
                    ];
                }
            }
        }

        return $sent;
    }

    /**
     * Gabungkan kolom tanggal + jam menjadi Carbon (timezone aplikasi).
     */
    public function bookingDateTime(BookingService $booking): ?Carbon
    {
        if (empty($booking->tanggal) || empty($booking->jam)) {
            return null;
        }

        try {
            return Carbon::parse(
                $booking->tanggal . ' ' . $booking->jam,
                config('app.timezone')
            );
        } catch (\Exception $e) {
            Log::warning('Gagal parse jadwal booking servis', [
                'booking_id' => $booking->id,
                'tanggal' => $booking->tanggal,
                'jam' => $booking->jam,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    /**
     * Cek apakah pengingat untuk tahap tertentu sudah pernah dibuat.
     */
    public function alreadySent(BookingService $booking, int $stage): bool
    {
        return Notification::query()
            ->where('source_type', BookingService::class)
            ->where('source_id', $booking->id)
            ->where('category', self::CATEGORY)
            ->where('reminder_stage', (string) $stage)
            ->exists();
    }

    /**
     * Simpan notifikasi ke DB lalu kirim FCM setelah commit.
     */
    protected function send(BookingService $booking, int $stage, Carbon $bookingAt): bool
    {
        $user = $booking->user;

        if (!$user) {
            return false;
        }

        $title = "Pengingat Servis {$stage} Menit Lagi";
        $description = $this->description($booking, $stage, $bookingAt);

        try {
            DB::transaction(function () use ($booking, $user, $stage, $title, $description) {
                Notification::create([
                    'user_public_id' => $user->id,
                    'source_type' => BookingService::class,
                    'source_id' => $booking->id,
                    'category' => self::CATEGORY,
                    'reminder_stage' => (string) $stage,
                    'title' => $title,
                    'description' => $description,
                    'is_read' => false,
                ]);
            });
        } catch (QueryException $e) {
            // Unique index (source_type, source_id, category, reminder_stage)
            // menahan duplikat saat scheduler berjalan bersamaan.
            Log::info('Pengingat servis sudah pernah dikirim, dilewati.', [
                'booking_id' => $booking->id,
                'stage' => $stage,
            ]);

            return false;
        }

        DB::afterCommit(function () use ($user, $title, $description, $booking, $stage) {
            $this->fcm->send(
                $user->fcm_token,
                $title,
                $description,
                [
                    'type' => 'service_reminder',
                    'booking_id' => (string) $booking->id,
                    'booking_code' => (string) $booking->booking_id,
                    'stage' => (string) $stage,
                    'tanggal' => (string) $booking->tanggal,
                    'jam' => (string) $booking->jam,
                ]
            );
        });

        return true;
    }

    protected function description(BookingService $booking, int $stage, Carbon $bookingAt): string
    {
        $model = $booking->motor->nama_model ?? 'motor Anda';
        $plat = $booking->motor->nomor_plat ?? null;
        $dealer = $booking->dealer->name_dealer ?? 'dealer';

        $motor = $plat ? "{$model} ({$plat})" : $model;

        return "Servis {$motor} di {$dealer} dijadwalkan pukul "
            . $bookingAt->format('H:i')
            . " hari ini. Waktu tersisa ±{$stage} menit, mohon segera bersiap.";
    }
}
