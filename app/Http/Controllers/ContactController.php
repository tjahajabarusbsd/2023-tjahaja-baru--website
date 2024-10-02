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
        $cookieSales = $request->cookie('sales');
        $urlParameter = $request->query('sales');
        $lists = Variant::all()->unique('name')->sortBy('name');

        $parameterValue = $request->input('sales');
        if ($parameterValue != null) {
            Cookie::queue('sales', $parameterValue);
        } else {
            Cookie::forget('sales');
        }

        return view('contact', compact('cookieSales', 'urlParameter', 'lists'));
    }

    public function submitPesanForm(ContactRequest $request, WhatsAppController $whatsAppController)
    {
        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
        if ($score > 0.7) {
            $phone = env('NO_MARKOM');
            
            $validatedData  = $request->validated();

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