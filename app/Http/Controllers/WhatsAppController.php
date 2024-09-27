<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class WhatsAppController extends Controller
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = 'https://api.1msg.io/434886/sendMessage';
        $this->apiToken = env('TOKEN_WA');
    }

    public function sendWhatsAppMessage(string $phone, string $messageBody)
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

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl, $data);
        
        $this->respon = $response->json();

        return $this->respon['sent'] === true
        ? response()->json(['message' => 'Message sent successfully'], 200) 
        : response()->json(['error' => 'Pesan gagal terkirim!'], 422);
    }
}