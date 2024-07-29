<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $client = app(Client::class);
        $url = $this->apiUrl . '?token=' . $this->apiToken;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $data = [
            'phone' => $phone,
            'body' => $messageBody,
        ];

        return $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);
    }
}
