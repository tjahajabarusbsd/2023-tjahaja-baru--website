<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = Event::ongoing()->get();

        $formattedEvents = $events->map(function ($event) {
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
            ];
        });

        return ApiResponse::success(
            $events->isNotEmpty()
            ? 'Daftar event berhasil diambil'
            : 'Tidak ada event tersedia',
            $formattedEvents
        );
    }

    public function show($id): JsonResponse
    {
        $event = Event::findOrFail($id);

        $event->increment('views');

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
        ];

        return ApiResponse::success(
            'Detail event berhasil diambil',
            $eventDetails
        );
    }
}
