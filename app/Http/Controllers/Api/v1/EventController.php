<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\Event\EventCheckinService;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $today = now()->startOfDay();

        // Event yang sudah berlalu tetap dikirim; mobile menampilkannya abu-abu.
        // Urutan: sedang berlangsung -> akan datang -> sudah berlalu (terbaru dulu).
        $events = Event::active()->get()
            ->sortBy(function (Event $event) use ($today) {
                $isPast = $event->end_date && $event->end_date->lt($today);
                $isUpcoming = $event->start_date && $event->start_date->gt($today);

                $group = $isPast ? 2 : ($isUpcoming ? 1 : 0);
                $timestamp = $event->start_date ? $event->start_date->timestamp : 0;

                return [$group, $isPast ? -$timestamp : $timestamp];
            })
            ->values();

        $formattedEvents = $events->map(function ($event) use ($today) {
            return [
                'id' => (string) $event->id,
                'title' => $event->name,
                'description' => Str::limit(strip_tags($event->description), 100, '...'),
                'image' => asset($event->image),
                'start_date' => $event->start_date
                    ? $event->start_date->format('d/m/Y')
                    : '',
                'end_date' => $event->end_date
                    ? $event->end_date->format('d/m/Y')
                    : '',
                'type' => $event->type,
                'location' => $event->location,
                'is_past' => (bool) ($event->end_date && $event->end_date->lt($today)),
                'checkin_enabled' => (bool) $event->checkin_enabled,
            ];
        });

        return ApiResponse::success(
            $events->isNotEmpty()
            ? 'Daftar event berhasil diambil'
            : 'Tidak ada event tersedia',
            $formattedEvents
        );
    }

    public function show(Request $request, $id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $event->increment('views');

        // Route ini publik; user hanya terisi kalau request membawa token (Bearer)
        $user = $request->bearerToken()
            ? Auth::guard('user_public')->user()
            : null;

        $eventDetails = [
            'id' => $event->id,
            'title' => $event->name,
            'timestamp' => $event->created_at
                ? $event->created_at->locale('id')->diffForHumans()
                : '',
            'views' => $event->views ?? 0,
            'description' => $event->description,
            'image' => asset($event->image),
            'start_date' => $event->start_date
                ? $event->start_date->format('d/m/Y')
                : '',
            'end_date' => $event->end_date
                ? $event->end_date->format('d/m/Y')
                : '',
            'type' => $event->type,
            'location' => $event->location,
            'checkin' => app(EventCheckinService::class)->statusPayload($event, $user),
        ];

        return ApiResponse::success(
            'Detail event berhasil diambil',
            $eventDetails
        );
    }
}
