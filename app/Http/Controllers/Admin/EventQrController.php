<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class EventQrController extends Controller
{
    /**
     * Render QR check-in event sebagai SVG (tanpa butuh ekstensi imagick).
     * Tambahkan ?download=1 untuk mengunduh sebagai file.
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);

        $token = $event->ensureCheckinToken();

        $svg = QrCode::format('svg')
            ->size(800)
            ->margin(2)
            ->errorCorrection('H')
            ->generate($token);

        $headers = [
            'Content-Type' => 'image/svg+xml',
            'Cache-Control' => 'no-store, no-cache, must-revalidate',
        ];

        if (request()->boolean('download')) {
            $headers['Content-Disposition'] = 'attachment; filename="qr-checkin-event-' . $event->id . '.svg"';
        }

        return response($svg, 200, $headers);
    }
}
