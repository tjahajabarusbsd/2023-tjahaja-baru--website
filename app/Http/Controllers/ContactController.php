<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use App\Models\Variant;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Cookie;

class ContactController extends Controller
{
    public function getContactForm(Request $request)
    {
        $lists = Variant::whereHas('group', function ($query) {
            $query->where('is_active', true);
        })->where('is_active', true)->get()->unique('name')->sortBy('name');

        $utmCampaignParameter = $request->query('utm_campaign');
        $salesCodeParameter = $request->query('sales');

        // Variable untuk menampung cookie yang akan disimpan ke database
        $cookieValue = null;

        // Cek dan set cookie utm_campaign
        if ($utmCampaignParameter) {
            Cookie::queue('utm_campaign', $utmCampaignParameter);
            $cookieValue = $utmCampaignParameter;
        } else {
            Cookie::forget('utm_campaign');
        }

        // Cek dan set cookie sales jika utm_campaign tidak ada
        // if ($salesCodeParameter && !$utmCampaignParameter) {
        //     Cookie::queue('sales', $salesCodeParameter);
        //     $cookieValue = $salesCodeParameter;
        // } else {
        //     Cookie::forget('sales');
        // }

        return view('contact', compact('cookieValue', 'lists'));
    }

    public function submitPesanForm(ContactRequest $request, WhatsAppController $whatsAppController)
    {
        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
        if ($score > 0.7) {
            $phone = env('NO_MARKOM');

            $validatedData = $request->validated();

            $contactData = Contact::storeSubmission($validatedData);

            $messageBody = $this->buildMessageBody($validatedData);

            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);

            if ($apiResponse->getStatusCode() === 200) {
                return response()->json(['successMessage' => 'Terima kasih, pesan Anda sudah berhasil terkirim!'], 201);
            } else {
                return response()->json(['errorMessage' => 'Pesan gagal terkirim!'], 422);
            }
        }

        return response()->json(['errorMessage' => 'Anda kemungkinan adalah bot'], 400);
    }

    private function buildMessageBody($validatedData)
    {
        $messageBody = [
            "Berikut ini data pengunjung yang mengisi form pesan di website kita:",
            "*Nama:* " . $validatedData['name'] . ", ",
            "*No HP:* " . $validatedData['nohp'] . ", ",
            "*Pesan:* " . $validatedData['message'] . ". "
        ];
        $messageBody[] = "Tolong segera diproses. Terima kasih.";

        return implode("", $messageBody);
    }
}