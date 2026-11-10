<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Variant;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

/*
 * Halaman /contact: form Pesan, Konsultasi Motor, dan Pinjaman Dana Tunai.
 *
 * - Halaman ini yang menampilkan ketiga form (view 'contact').
 * - Submit form Pesan ditangani di sini (submitPesanForm).
 * - Submit form Konsultasi Motor ada di ConsultationController::submitConsultationForm.
 * - Cookie 'sales' diset saat pengunjung membuka link sales di home (/?sales=KODE),
 *   bukan di sini. Di halaman ini cookie hanya dibaca blade lewat request()->hasCookie('sales').
 */

class ContactController extends Controller
{
    public function getContactForm(Request $request): View
    {
        $lists = Variant::whereHas('group', function ($query) {
            $query->where('is_active', true);
        })->where('is_active', true)->get()->unique('name')->sortBy('name');

        // Cookie utm_campaign dibaca ConsultationController untuk mencatat asal lead
        // dan dipakai blade untuk menampilkan form motor langsung.
        // Tidak dihapus bila parameter tidak ada, jadi tetap berlaku sampai sesi berakhir.
        $utmCampaign = $request->query('utm_campaign');

        if (is_string($utmCampaign) && $utmCampaign !== '') {
            Cookie::queue('utm_campaign', $utmCampaign);
        }

        return view('contact', compact('lists'));
    }

    public function submitPesanForm(ContactRequest $request, WhatsAppController $whatsAppController)
    {
        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
        if ($score > 0.7) {
            $phone = config('services.whatsapp.markom_number');

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
