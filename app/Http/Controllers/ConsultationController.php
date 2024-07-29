<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Variant;
use App\Models\Consultation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use App\Http\Requests\ConsultationRequest;
use App\Http\Controllers\WhatsAppController;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

use Illuminate\Support\Facades\URL;

class ConsultationController extends Controller
{
    public function getConsultationForm(Request $request)
    {
        $value = $request->query('sales');
        $lists = Variant::all()->unique('name')->sortBy('name');

        $parameterValue = $request->input('sales');
        if ($parameterValue != null) {
            Cookie::queue('sales', $parameterValue);
        } else {
            Cookie::forget('sales');
        }

        return view('consultation', compact('value', 'lists'));
    }

    public function submitConsultationForm(ConsultationRequest $request, WhatsAppController $whatsAppController)
    {
        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'consultation');
        
        if ($score > 0.7) {
            $salesCode = $request->cookie('sales');
            $currentURL = $request->input('url');
            $charactersAfterLastSlash = substr($currentURL, strrpos($currentURL, '/') + 1);
            if (!empty($salesCode)) {
                // Retrieve the phone number from the database based on the code
                $staff = Staff::where('code', $salesCode)->first();
                if (!$staff) {
                    return redirect()->back()->with('error', 'Submit gagal');
                }
                $phone = $staff->phone; // Phone number retrieved from the staff record
                $phone = str_replace("+", "", $phone);
            } else {
                $phone = '62811805898'; // Default phone number
            }

            $selectedOption = $request->input('produk');
            
            $validatedData  = $request->validated();
            
            $consultationData = Consultation::storeSubmission($validatedData, $charactersAfterLastSlash, $salesCode);
            
            $messageBody = $this->buildMessageBody($validatedData, $selectedOption);
            
            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);

            if ($apiResponse->getStatusCode() === 200) {
                $successMessage = "Pengajuan Anda telah diterima.\nDealer kami akan segera menghubungi Anda.";

                $deleteCookie = Cookie::forget('sales');
            
                $previousUrl = URL::previous();
                $previousUrlWithoutParams = strtok($previousUrl, '?');
            
                return redirect($previousUrlWithoutParams)->withCookie($deleteCookie)->with('success', $successMessage);
            } else {
                // Jika gagal mengirim pesan WhatsApp, roll back data
                $consultationData->delete(); // Menghapus data yang telah disimpan
                return response()->json(['errorMessage' => 'Failed to send WhatsApp message'], 422);
            }
        }

        return response()->json(['errorMessage' => 'You are most likely a bot'], 422);
    }

    private function buildMessageBody(array $validatedData, $selectedOption)
    {
        $messageBody = [
            "Hi, Dealer,",
            "Berikut ini data konsumen yang mengisi form di website kita yang minat dengan produk Yamaha:",
            "Nama: " . $validatedData['name'],
            "No HP: " . $validatedData['nohp'],
            "Produk yang diminati: " . $selectedOption,
        ];
        $messageBody[] = "Tolong segera diproses. Terima kasih.";

        return implode("\n", $messageBody);
    }
}
