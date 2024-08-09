<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use App\HTTP\Controllers\WhatsAppController;

class AjukanController extends Controller
{
    public function ajukanAngsuran(Request $request, WhatsAppController $whatsAppController)
    {   
        $currentURL = $request->input('url');
        $charactersAfterLastSlash = substr($currentURL, strrpos($currentURL, '/') + 1);
        
        if ($charactersAfterLastSlash == 'myprofile') {
            $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'ajukan_pinjaman');
        } else {
            $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'contact');
        }

        if ($recaptchaResponse > 0.7) {
            $phone = '62812';
            if ($charactersAfterLastSlash == 'myprofile') {
                $user = Auth::user();

                if (empty($user->name)) {
                    return response()->json(['errorMessage' => 'Nama pengguna tidak boleh kosong.'], 422);
                }
            
                if (empty($user->phone_number)) {
                    return response()->json(['errorMessage' => 'Nomor HP pengguna tidak boleh kosong.'], 422);
                }

                $messageBody = $this->buildMessageBody($request, $user);
            } else {
                $validateData = $request->validate([
                    'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
                    'nohp' => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
                ], [
                    'name.required' => 'Nama wajib diisi.',
                    'name.regex' => 'Wajib menggunakan huruf.',
                    'name.max' => 'Nama maksimal 50 karakter.',
                    'nohp.required' => 'Nomor HP wajib diisi.',
                    'nohp.numeric' => 'Wajib menggunakan angka.',
                    'nohp.regex' => 'Mohon input nomor HP dengan benar.',
                ]);
                $messageBody = $this->buildMessageBodyContact($request, $validateData);
            }

            // dd($messageBody);

            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);

            if ($apiResponse->getStatusCode() === 200) {
                return response()->json(['successMessage' => 'Pengajuan Anda telah diterima'], 201);
            } else {
                return response()->json(['errorMessage' => 'Failed to send message'], 422);
            }
            
            // $apiResponse = 200;

            // if($apiResponse === 200) {
            //     return response()->json(['successMessage' => 'Pengajuan Anda telah diterima!'], 201);
            // } else {
            //     return response()->json(['errorMessage' => 'Pesan gagal terkirim!'], 422);
            // }
        }
        
        return response()->json(['errorMessage' => 'Anda kemungkinan adalah bot'], 422);
    }

    private function getRequestData(Request $request, $user)
    {
        return [
            'name' => $user->name,
            'nohp' => $user->phone_number,
            'tipe' => $request->tipe,
            'unit_tahun' => $request->unit_tahun,
            'harga_motor' => $request->harga_motor,
            'dana_dicairkan' => $request->dana_dicairkan,
            'tenor' => $request->tenor,
            'tipeLain' => $request->tipeLain,
            'angsuranMonthly' => $request->angsuranMonthly,
        ];
    }

    private function getRequestDataContact(Request $request)
    {
        return [
            'name' => $request->name,
            'nohp' => $request->nohp,
            'tipe' => $request->tipe,
            'unit_tahun' => $request->unit_tahun,
            'harga_motor' => $request->harga_motor,
            'dana_dicairkan' => $request->dana_dicairkan,
            'tenor' => $request->tenor,
            'tipeLain' => $request->tipeLain,
            'angsuranMonthly' => $request->angsuranMonthly,
        ];
    }

    private function buildMessageBody($request, $user)
    {
        $messageBody = [
            "Ada calon Nasabah mengajukan dana tunai dari simulasi di website dengan informasi sebagai berikut:",
            "Nama: " . $user->name,
            "No HP: " . $user->phone_number,
        ];

        if ($request['tipe'] !== 'other') {
            $messageBody[] = "Tipe Motor: " . $request['tipe'];
        }

        if ($request['tipeLain'] !== null) {
            $messageBody[] = "Tipe Motor: " . $request['tipeLain'];
        }

        $messageBody[] = "Tahun Motor: " . $request['unit_tahun'];
        $messageBody[] = "Harga OTR(Estimasi): " . 'Rp ' . number_format($request['harga_motor'], 0, ',', '.');
        $messageBody[] = "Nilai Diminta: " . 'Rp ' . number_format($request['dana_dicairkan'], 0, ',', '.');
        $messageBody[] = "Tenor: " . $request['tenor'];
        $messageBody[] = "Angsuran(Estimasi): " . 'Rp ' . number_format($request['angsuranMonthly'], 0, ',', '.');
        $messageBody[] = "Tolong segera diproses. Terima kasih.";
        
        return implode("\n", $messageBody);
    }

    private function buildMessageBodyContact($request, $validateData)
    {
        $messageBody = [
            "Ada calon Nasabah mengajukan dana tunai dari simulasi di website dengan informasi sebagai berikut:",
            "Nama: " . $validateData['name'],
            "No HP: " . $validateData['nohp'],
        ];

        if ($request['tipe'] !== 'other') {
            $messageBody[] = "Tipe Motor: " . $request['tipe'];
        }

        if ($request['tipeLain'] !== null) {
            $messageBody[] = "Tipe Motor: " . $request['tipeLain'];
        }

        $messageBody[] = "Tahun Motor: " . $request['unit_tahun'];
        $messageBody[] = "Harga OTR(Estimasi): " . 'Rp ' . number_format($request['harga_motor'], 0, ',', '.');
        $messageBody[] = "Nilai Diminta: " . 'Rp ' . number_format($request['dana_dicairkan'], 0, ',', '.');
        $messageBody[] = "Tenor: " . $request['tenor'];
        $messageBody[] = "Angsuran(Estimasi): " . 'Rp ' . number_format($request['angsuranMonthly'], 0, ',', '.');
        $messageBody[] = "Tolong segera diproses. Terima kasih.";
        
        return implode("\n", $messageBody);
    }
}