<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        $events = [
            [
                'id' => '1',
                'title' => 'Event 1',
                'subtitle' => 'Dp Mulai 1.5 Juta',
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
                'image' => 'https://duckdumber.com/bannerEvent1.png',
                'start_date' => '12/12/2025',
                'end_date' => '31/12/2025',
                'type' => 'online',
            ],
            [
                'id' => '2',
                'title' => 'Event 2',
                'subtitle' => 'Dp Mulai 1.5 Juta',
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.",
                'image' => 'https://duckdumber.com/bannerEvent1.png',
                'start_date' => '12/12/2025',
                'end_date' => '31/12/2025',
                'type' => 'offline',
            ],
        ];

        return response()->json([
            'status' => 'success',
            'code' => 200,
            'message' => 'Daftar event berhasil diambil',
            'data' => $events,
        ], 200);
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
