<?php

namespace App\Http\Controllers\Api\v1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\QrScanLogDetailResource;
use App\Models\QrScanLog;
use Illuminate\Http\Request;
use Spatie\FlareClient\Api;

class QrScanLogController extends Controller
{
    public function show($id, Request $request)
    {
        $user = $request->user();

        $scan = QrScanLog::with(['qrcode'])
            ->where('id', $id)
            ->where('user_public_id', $user->id)
            ->first();

        if (!$scan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return ApiResponse::success('Detail scan QR code', new QrScanLogDetailResource($scan));
    }
}