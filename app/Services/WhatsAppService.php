<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    // Pindahkan konfigurasi ke sini atau ke config file
    protected string $apiUrl;
    protected string $apiToken;

    public function __construct()
    {
        // Opsi 1: Hardcode (masih ok untuk sementara)
        $this->apiUrl = 'https://api.1msg.io/434886/sendMessage';
        $this->apiToken = env('TOKEN_WA');

        // Opsi 2: Lebih baik, gunakan config file (rekomendasi)
        // $this->apiUrl = config('services.whatsapp.url');
        // $this->apiToken = config('services.whatsapp.token');
    }

    /**
     * Mengirim pesan WhatsApp melalui API.
     * Method ini PURE: hanya punya satu tanggung jawab dan tidak mengubah response.
     *
     * @param string $phone
     * @param string $messageBody
     * @return \Illuminate\Http\Client\Response
     */
    public function send(string $phone, string $messageBody): Response
    {
        $data = [
            "token" => $this->apiToken,
            "namespace" => "f5d85327_a726_4871_9de1_3bdb33fd47d2",
            "template" => "default_reply_incoming_message",
            "language" => [
                "policy" => "deterministic",
                "code" => "id"
            ],
            "params" => [
                [
                    "type" => "body",
                    "parameters" => [
                        [
                            "type" => "text",
                            "text" => $messageBody,
                        ]
                    ]
                ]
            ],
            "phone" => $phone
        ];

        // Kirim request dan dapatkan response MENTAH dari API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, $data);

        // Logging untuk debugging sangat penting!
        if ($response->failed()) {
            Log::channel('whatsapp')->error('WhatsApp API Failed', [
                'phone' => $phone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
        } else {
            Log::channel('whatsapp')->info('WhatsApp API Success', [
                'phone' => $phone,
                'body' => $response->body(),
            ]);
        }

        // KEMBALIKAN RESPONSE MENTAH. Jangan diubah-ubah lagi di sini.
        return $response;
    }
}