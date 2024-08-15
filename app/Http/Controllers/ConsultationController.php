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
use Illuminate\Http\Response;
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
        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
        
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
                $phone = '62812'; // Default phone number
            }
            
            $validatedData  = $request->validated();

            $validatedDataDP = $validatedData['dp'];
            $dpValue = null;
            if (!empty($validatedDataDP)) {
                if ($validatedDataDP == 'dp-0') {
                    $dpValue = 'Rp. 1 Juta - 5 Juta';
                } else if($validatedDataDP == 'dp-1') {
                    $dpValue = 'Rp. 5 Juta - 10 Juta';
                } else if($validatedDataDP == 'dp-2') {
                    $dpValue = 'Rp. 10 Juta - 15 Juta';
                } else {
                    $dpValue = 'Diatas Rp 15 juta';
                }
            }

            $consultationData = Consultation::storeSubmission($validatedData, $dpValue, $charactersAfterLastSlash, $salesCode);
            
            $messageBody = $this->buildMessageBody($validatedData, $dpValue);
            
            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);
                
            if ($apiResponse->getStatusCode() === 200) {
                $successMessage = "Pengajuan Anda telah diterima.\nDealer kami akan segera menghubungi Anda.";
                $deleteCookie = Cookie::forget('sales');
                
                $response = new Response([
                    'successMessage' => $successMessage
                ], 201);
    
                $response->withCookie($deleteCookie);
                return $response;
            } else { 
                $consultationData->delete(); 
                return response()->json(['errorMessage' => 'Pesan gagal terkirim!'], 422);
            }
        }

        return response()->json(['errorMessage' => 'Anda kemungkinan adalah bot'], 400);
    }

    private function buildMessageBody($validatedData, $dpValue)
    {
        $messageBody = [
            "Berikut ini data konsumen yang mengisi form di website kita yang minat dengan produk Yamaha:",
            "Nama: " . $validatedData['name'],
            "No HP: " . $validatedData['nohp'],
            "Produk yang diminati: " . $validatedData['produk'],
        ];

        if ($validatedData['cara_bayar'] === 'kredit') {
            $messageBody[] = "Cara bayar: " . $validatedData['cara_bayar'];
            $messageBody[] = "DP: " . $dpValue;
            $messageBody[] = "Tenor: " . $validatedData['tenor'] . " bulan";
        }

        if ($validatedData['cara_bayar'] === 'cash') {
            $messageBody[] = "Cara bayar: " . $validatedData['cara_bayar'];
        }

        $messageBody[] = "Tolong segera diproses. Terima kasih.";

        return implode("\n", $messageBody);
    }
}
