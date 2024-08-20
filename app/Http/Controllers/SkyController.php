<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use App\Models\SkySubmission;
use App\Http\Requests\SkySubmissionRequest;
use App\Http\Controllers\WhatsAppController;

class SkyController extends Controller
{
    public function skySend(SkySubmissionRequest $request, WhatsAppController $whatsAppController)
    {
        $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'send_sky');
        
        if ($recaptchaResponse >= 0.7) {
            $user = Auth::user();  
            $phone = '62812';
            $validatedData  = $request->validated();
            $skyData = SkySubmission::storeSubmission($validatedData, $user);
            $messageBody = $this->buildMessageBody($validatedData);
            
            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);
            
            if ($apiResponse->getStatusCode() === 200) {
                return response()->json(['successMessage' => 'Pengajuan Anda telah diterima'], 201);
            }

            return response()->json(['errorMessage' => 'Failed to send message'], 422);
        }

        return response()->json(['errorMessage' => 'You are most likely a bot'], 422);
    }

    private function buildMessageBody(array $validatedData)
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

}
