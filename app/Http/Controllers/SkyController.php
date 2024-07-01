<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SkySubmissionRequest;
use App\Models\SkySubmission; 
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Validator;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use GuzzleHttp\Client;

class SkyController extends Controller
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = 'https://api.1msg.io/434886/sendMessage';
        $this->apiToken = env('TOKEN_WA');
    }

    public function skySend(SkySubmissionRequest $request)
    {
        $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'send_sky');
        
        if ($recaptchaResponse >= 0.7) {
            $user = Auth::user();

            $validatedData  = $this->getRequestData($request);
            $skyData = $this->storeSkyData($validatedData , $user);
            $messageBody = $this->buildMessageBody($validatedData, $user);
            $apiResponse = $this->sendMessage($messageBody);
            
            if ($apiResponse->getStatusCode() === 200) {
                return response()->json(['successMessage' => 'Pengajuan Anda telah diterima'], 201);
            }

            return response()->json(['errorMessage' => 'Failed to send message'], 422);
        }

        return response()->json(['errorMessage' => 'You are most likely a bot'], 422);
    }

    private function getRequestData(SkySubmissionRequest $request)
    {
        return $request->validated();
    }

    private function storeSkyData(array $validatedData, $user)
    {
        $submission = SkySubmission::create([
            'name' => $validatedData['sky_name'],
            'nohp' => $validatedData['sky_phone_number'],
            'alamat' => $validatedData['sky_alamat'],
            'tipe' => $validatedData['sky_tipe'],
            'kendala' => $validatedData['sky_kendala'],
            'user_id' => $user->id,
        ]);
    }

    private function buildMessageBody(array $validatedData, $user)
    {
        $messageBody = [
            "Konsumen dengan data berikut melakukan pengajuan SKY dari website:",
            "Nama: " . $validatedData['sky_name'],
            "No HP: " . $validatedData['sky_phone_number'],
            "Alamat: " . $validatedData['sky_alamat'],
            "Tipe Motor: " . $validatedData['sky_tipe'],
            "Kendala: " . $validatedData['sky_kendala']
        ];
        $messageBody[] = "Tolong segera diproses. Terima kasih.";

        return implode("\n", $messageBody);
    }

    private function sendMessage(string $messageBody)
    {
        $client = app(Client::class);
        $url = $this->apiUrl . '?token=' . $this->apiToken;
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $data = [
            'phone' => '628123', // ganti nomor ini nanti
            'body' => $messageBody,
        ];

        return $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);
    }
}
