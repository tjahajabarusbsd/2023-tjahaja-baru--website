<?php

namespace App\Services\Booking;

use App\Models\BookingService;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Throwable;

/**
 * Aturan kapan user masih boleh membatalkan booking servisnya.
 *
 * Aturan tunggal: booking boleh dibatalkan sampai
 * `jam servis - config('booking.cancel_cutoff_hours')` (default 2 jam).
 * Pengingat servis baru mulai 60 menit sebelum jam servis, jadi tidak
 * pernah ada booking yang sudah menerima pengingat lalu dibatalkan.
 */
class BookingCancelPolicy
{
    /** Status yang secara prinsip masih bisa dibatalkan user. */
    public const CANCELLABLE_STATUSES = ['pending', 'booking', 'confirmed'];

    /** Status dari DPACK yang menandakan servis sudah berjalan / selesai. */
    private const BLOCKED_EXTERNAL_STATUSES = ['progress', 'done', 'cancelled', 'completed'];

    /**
     * Gabungkan kolom tanggal + jam menjadi waktu servis (timezone aplikasi).
     */
    public function appointmentAt(BookingService $booking): ?CarbonInterface
    {
        if (empty($booking->tanggal) || empty($booking->jam)) {
            return null;
        }

        try {
            return Carbon::parse(
                $booking->tanggal . ' ' . $booking->jam,
                config('app.timezone')
            );
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * Batas akhir pembatalan = jam servis dikurangi cutoff.
     */
    public function deadline(BookingService $booking): ?CarbonInterface
    {
        $appointment = $this->appointmentAt($booking);

        if (!$appointment) {
            return null;
        }

        return $appointment->copy()->subHours($this->cutoffHours());
    }

    public function cutoffHours(): int
    {
        return (int) config('booking.cancel_cutoff_hours', 2);
    }

    public function canCancel(BookingService $booking): bool
    {
        if (!in_array($booking->status, self::CANCELLABLE_STATUSES, true)) {
            return false;
        }

        $external = strtolower((string) $booking->external_status);

        if (in_array($external, self::BLOCKED_EXTERNAL_STATUSES, true)) {
            return false;
        }

        $deadline = $this->deadline($booking);

        return $deadline !== null && now()->lessThan($deadline);
    }

    /**
     * Alasan booking tidak bisa dibatalkan, dipakai app untuk menampilkan
     * keterangan di bawah tombol batal.
     */
    public function reason(BookingService $booking): ?string
    {
        if ($this->canCancel($booking)) {
            return null;
        }

        if (in_array($booking->status, ['cancelled'], true)) {
            return 'Booking ini sudah dibatalkan.';
        }

        if (in_array($booking->status, ['progress', 'done', 'completed'], true)) {
            return 'Servis sudah diproses dealer, booking tidak dapat dibatalkan.';
        }

        $external = strtolower((string) $booking->external_status);

        if (in_array($external, self::BLOCKED_EXTERNAL_STATUSES, true)) {
            return 'Servis sudah diproses dealer, booking tidak dapat dibatalkan.';
        }

        if ($this->appointmentAt($booking) === null) {
            return 'Jadwal booking tidak valid, silakan hubungi dealer.';
        }

        return 'Pembatalan ditutup ' . $this->cutoffHours()
            . ' jam sebelum jadwal servis. Silakan hubungi dealer.';
    }
}
