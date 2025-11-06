<?php

namespace App\Http\Controllers;

use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse; // Tambahkan use statement yang benar

class WhatsAppController extends Controller
{
    protected WhatsAppService $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Method ini menjaga interface (tanda tangan) yang sama agar tidak merusak kode lain.
     * Sekarang, method ini hanya bertindak sebagai perantara.
     *
     * @param string $phone
     * @param string $messageBody
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendWhatsAppMessage(string $phone, string $messageBody): JsonResponse
    {
        $apiResponse = $this->whatsAppService->send($phone, $messageBody);

        if ($apiResponse->successful() && $apiResponse->json('sent') === true) {
            return response()->json(['message' => 'Message sent successfully'], 200);
        }

        $errorMessage = $apiResponse->json('error_message', 'Pesan gagal terkirim!');
        return response()->json(['error' => $errorMessage], 422);
    }
}