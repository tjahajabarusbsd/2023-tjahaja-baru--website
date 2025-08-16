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
                'image' => $event->image
                    ? asset('storage/' . $event->image)
                    : '',
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
            'Daftar event berhasil diambil',
            $formattedEvents
        );
    }

    public function show($id): JsonResponse
    {
        // Contoh data dummy untuk detail event
        $eventDetails = [
            '1' => [
                'id' => 1,
                'title' => 'Event 1',
                'timestamp' => '1 jam lalu',
                'views' => 230,
                'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu turpis molestie, dictum est a, mattis tellus. Sed dignissim, metus nec fringilla accumsan, risus sem sollicitudin lacus, ut interdum tellus elit sed risus.\n\nMaecenas eget condimentum velit, sit amet feugiat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Praesent auctor purus luctus enim egestas, ac scelerisque ante pulvinar.",
                'bannerImage' => 'https://duckdumber.com/banerEventDetail.png',
                'promo' => [
                    'headline' => 'Dp Mulai',
                    'amount' => '1,5 Juta',
                    'note' => '*S&K Berlaku',
                    'cta' => 'Dapatkan Keuntungan Beli Motor Classy Bulan Ini!',
                ],
            ],
            // Tambah data event lainnya jika perlu
        ];

        if (!isset($eventDetails[$id])) {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Event tidak ditemukan',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Data event berhasil dimuat',
            'data' => $eventDetails[$id],
        ], 200);
    }
}