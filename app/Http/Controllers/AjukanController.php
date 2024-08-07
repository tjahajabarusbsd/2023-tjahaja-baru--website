<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class AjukanController extends Controller
{
    private $apiUrl;
    private $apiToken;

    public function __construct()
    {
        $this->apiUrl = 'https://api.1msg.io/434886/sendMessage';
        $this->apiToken = env('TOKEN_WA');
    }

    public function ajukanAngsuran(Request $request)
    {
        $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'ajukan_pinjaman');

        if ($recaptchaResponse > 0.7) {
            $user = Auth::user();
            $requestData = $this->getRequestData($request);
            $messageBody = $this->buildMessageBody($requestData, $user);
            $apiResponse = $this->sendMessage($messageBody);

            if ($apiResponse->getStatusCode() === 200) {
                return response()->json(['successMessage' => 'Pengajuan Anda telah diterima'], 201);
            }

            return response()->json(['errorMessage' => 'Failed to send message'], 422);
        }
        
        return response()->json(['errorMessage' => 'You are most likely a bot'], 422);
    }

    private function getRequestData(Request $request)
    {
        return [
            'tipe' => $request->tipe,
            'unit_tahun' => $request->unit_tahun,
            'harga_motor' => $request->harga_motor,
            'dana_dicairkan' => $request->dana_dicairkan,
            'tenor' => $request->tenor,
            'tipeLain' => $request->tipeLain,
            'angsuranMonthly' => $request->angsuranMonthly,
        ];
    }

    private function buildMessageBody(array $requestData, $user)
    {
        $messageBody = [
            "Ada calon Nasabah mengajukan dana tunai dari simulasi di website dengan informasi sebagai berikut:",
            "Nama: " . $user->name,
            "No HP: " . $user->phone_number,
        ];

        if ($requestData['tipe'] !== 'other') {
            $messageBody[] = "Tipe Motor: " . $requestData['tipe'];
        }

        if ($requestData['tipeLain'] !== null) {
            $messageBody[] = "Tipe Motor: " . $requestData['tipeLain'];
        }

        $messageBody[] = "Tahun Motor: " . $requestData['unit_tahun'];
        $messageBody[] = "Harga OTR(Estimasi): " . $requestData['harga_motor'];
        $messageBody[] = "Nilai Diminta: " . $requestData['dana_dicairkan'];
        $messageBody[] = "Tenor: " . $requestData['tenor'];
        $messageBody[] = "Angsuran(Estimasi): " . $requestData['angsuranMonthly'];
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
            'phone' => '628123123', // ganti nomor ini nanti
            'body' => $messageBody,
        ];

        return $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);
    }
}