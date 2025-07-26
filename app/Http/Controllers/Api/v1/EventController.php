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
}
