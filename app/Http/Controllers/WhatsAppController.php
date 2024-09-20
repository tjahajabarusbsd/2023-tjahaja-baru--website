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
        // $client = app(Client::class);
        // $url = $this->apiUrl . '?token=' . $this->apiToken;
        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json',
        // ];

        // $data = [
        //     'phone' => $phone,
        //     'body' => $messageBody,
        // ];

        // return $client->post($url, [
        //     'headers' => $headers,
        //     'json' => $data,
        // ]);

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

        $ch = curl_init($this->apiUrl);
        
        // Set the options for the POST request
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);

        // Convert the PHP array to JSON and send it
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the POST request and get the response
        $response = curl_exec($ch);
        
        $this->respon = json_decode($response, true);
        
        // Close cURL
        curl_close($ch);

        // if (isset($this->respon['sent']) && $this->respon['sent'] === true) {
        //     return true;
        // } else {
        //     return false;
        // }
        return $this->respon['sent'] === true
        ? response()->json(['message' => 'Message sent successfully'], 200) 
        : response()->json(['error' => 'Pesan gagal terkirim!'], 422);
    }
}