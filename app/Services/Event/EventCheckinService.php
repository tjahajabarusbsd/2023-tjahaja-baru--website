<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Models\EventCheckin;
use App\Models\FeatureStatus;
use App\Models\UserPublic;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EventCheckinService
{
    /**
     * Cek apakah kode QR yang di-scan adalah QR event (bukan QR promo).
     */
    public static function isEventCode(?string $code): bool
    {
        return str_starts_with(trim((string) $code), Event::CHECKIN_TOKEN_PREFIX);
    }

    /**
     * Catat check-in user ke sebuah event.
     *
     * @throws Exception berisi pesan siap tampil + kode HTTP
     */
    public function checkin(UserPublic $user, string $code): array
    {
        $this->ensureFeatureActive();

        $code = trim($code);

        [$event, $checkin] = DB::transaction(function () use ($user, $code) {
            $event = Event::where('checkin_token', $code)
                ->lockForUpdate()
                ->first();

            if (! $event) {
                throw new Exception('QR event tidak valid', 404);
            }

            if (! $event->checkin_enabled) {
                throw new Exception('Check-in event tidak aktif', 400);
            }

            [$from, $to] = $event->checkinWindow();

            if ($from && now()->lt($from)) {
                throw new Exception('Check-in belum dibuka', 400);
            }

            if ($to && now()->gt($to)) {
                throw new Exception('Check-in sudah ditutup', 400);
            }

            try {
                $checkin = EventCheckin::create([
                    'event_id' => $event->id,
                    'user_public_id' => $user->id,
                    'checked_in_at' => now(),
                ]);
            } catch (QueryException $e) {
                // Unique (event_id, user_public_id) dilanggar = user sudah check-in
                if ((string) $e->getCode() === '23000') {
                    throw new Exception('Anda sudah check-in di event ini', 400);
                }

                throw $e;
            }

            return [$event, $checkin];
        });

        return [
            'type' => 'event_checkin',
            'event_id' => (string) $event->id,
            'event_name' => $event->name,
            'event_image' => $event->image ? asset($event->image) : null,
            'location' => $event->location,
            'checkin_code' => $checkin->checkin_code,
            'checked_in_at' => $checkin->checked_in_at->format('d/m/Y H:i'),
            'total_checkins' => EventCheckin::where('event_id', $event->id)->count(),
        ];
    }

    /**
     * Status check-in user pada sebuah event, untuk halaman detail event.
     */
    public function statusPayload(Event $event, ?UserPublic $user): array
    {
        $mine = null;

        if ($user) {
            $mine = EventCheckin::where('event_id', $event->id)
                ->where('user_public_id', $user->id)
                ->first();
        }

        [$from, $to] = $event->checkinWindow();

        return [
            'enabled' => (bool) $event->checkin_enabled,
            'is_open' => $event->checkin_enabled && $event->checkinOpen(),
            'open_at' => $from ? $from->toIso8601String() : null,
            'close_at' => $to ? $to->toIso8601String() : null,
            'already_checked_in' => (bool) $mine,
            'my_checkin' => $mine ? [
                'code' => $mine->checkin_code,
                'checked_in_at' => $mine->checked_in_at->format('d/m/Y H:i'),
            ] : null,
        ];
    }

    /**
     * Key tidak ada di tabel = dianggap aktif (fail-open), sama seperti middleware feature:*.
     */
    private function ensureFeatureActive(): void
    {
        if (! Schema::hasTable('feature_statuses')) {
            return; // tabel belum dimigrasikan: anggap aktif (fail-open)
        }

        $status = FeatureStatus::where('key', 'event_checkin')->first();

        if ($status && ! $status->is_active) {
            throw new Exception(
                $status->maintenance_message ?? 'Fitur check-in event sedang maintenance',
                503
            );
        }
    }
}
