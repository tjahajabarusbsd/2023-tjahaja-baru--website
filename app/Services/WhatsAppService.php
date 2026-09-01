<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;
use App\Exceptions\WhatsAppSendException;

class WhatsAppService
{
    // Pindahkan konfigurasi ke sini atau ke config file
    protected string $apiUrl;
    protected string $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('services.whatsapp.url');
        $this->apiToken = config('services.whatsapp.token');
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

        $body = $response->json();
        // Provider ini bisa balas HTTP 200 tapi tetap gagal kirim,
        // jadi cek eksplisit field "sent" di body, jangan andalkan status code saja.
        $sentSuccessfully = $response->successful() && ($body['sent'] ?? false) === true;

        if (!$sentSuccessfully) {
            Log::channel('whatsapp')->error('WhatsApp API Failed', [
                'phone' => $phone,
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            throw new WhatsAppSendException(
                $body['error'] ?? 'Gagal mengirim pesan WhatsApp',
                $response->status()
            );
        }

        Log::channel('whatsapp')->info('WhatsApp API Success', [
            'phone' => $phone,
            'body' => $response->body(),
        ]);

        return $response;
    }
}
