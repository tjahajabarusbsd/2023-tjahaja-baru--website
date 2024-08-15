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

    public function submitConsultationForm(Request $request, WhatsAppController $whatsAppController)
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
            
            $validated = $request->validate([
                'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
                'nohp' => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
                'produk' => 'required',
                'payment_method' => 'required',
                'down_payment' => 'required_if:payment_method,kredit', 
                'tenor_pembelian' => 'required_if:payment_method,kredit',
                'g-recaptcha-response' => 'required',
                'terms'  => 'required|accepted'
            ], [
                'name.required' => 'Nama wajib diisi.',
                'name.regex' => 'Wajib menggunakan huruf.',
                'name.max' => 'Nama maksimal 50 karakter.',
                'nohp.required' => 'Nomor HP wajib diisi.',
                'nohp.numeric' => 'Wajib menggunakan angka.',
                'nohp.regex' => 'Nomor HP tidak valid.',
                'produk.required' => 'Produk wajib dipilih.',
                'payment_method.required' => 'Metode pembayaran belum dipilih.',
                'down_payment.required_if' => 'Down payment wajib dipilih.',
                'tenor_pembelian.required_if' => 'Tenor pembelian wajib dipilih.',
                'g-recaptcha-response.required' => 'Captcha tidak valid. Mohon reload page.',
                'terms.required' => 'Saya setuju dengan syarat dan ketentuan.',
                'terms.accepted' => 'Saya setuju dengan syarat dan ketentuan.'
            ]);

            $validatedDataDP = $request['down_payment'];
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

            $consultationData = Consultation::storeSubmission($request, $dpValue, $charactersAfterLastSlash, $salesCode);
            
            $messageBody = $this->buildMessageBody($request, $dpValue);
            
            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);
                
            if ($charactersAfterLastSlash == 'contact') {
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
            } else {
                if ($apiResponse->getStatusCode() === 200) {
                    $successMessage = "Pengajuan Anda telah diterima.\nDealer kami akan segera menghubungi Anda.";
                    $deleteCookie = Cookie::forget('sales');
                    $previousUrl = URL::previous();
                    $previousUrlWithoutParams = strtok($previousUrl, '?');
                
                    return redirect($previousUrlWithoutParams)->withCookie($deleteCookie)->with('success', $successMessage);
                } else {
                    $consultationData->delete(); 
                    $errorMessage = "Pesan gagal terkirim!";
                    return redirect()->back()->with('error', $errorMessage);
                }
            }            
        }

        $errorMessage = "Anda kemungkinan adalah bot";
        return redirect()->back()->with('error', $errorMessage);
    }

    private function buildMessageBody($request, $dpValue)
    {
        $messageBody = [
            "Hi, Dealer,",
            "Berikut ini data konsumen yang mengisi form di website kita yang minat dengan produk Yamaha:",
            "Nama: " . $request['name'],
            "No HP: " . $request['nohp'],
            "Produk yang diminati: " . $request['produk'],
        ];

        if ($request['payment_method'] === 'kredit') {
            $messageBody[] = "Cara bayar: " . $request['payment_method'];
            $messageBody[] = "DP: " . $dpValue;
            $messageBody[] = "Tenor: " . $request['tenor_pembelian'] . " bulan";
        }

        if ($request['payment_method'] === 'cash') {
            $messageBody[] = "Cara bayar: " . $request['payment_method'];
        }

        $messageBody[] = "Tolong segera diproses. Terima kasih.";

        return implode("\n", $messageBody);
    }
}
