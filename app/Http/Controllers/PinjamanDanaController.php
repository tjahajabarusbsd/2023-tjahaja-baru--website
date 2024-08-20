<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use App\Models\Spec;
use App\Models\PinjamanDana;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Auth;

class PinjamanDanaController extends Controller
{
    public function hitungPinjaman(Request $request)
    {
        $hargaMotor = $request->harga_motor;
        
        $maksimalPinjaman = $hargaMotor * 0.8; 

        return response()->json(['maksimal_pinjaman' => $maksimalPinjaman]);
    }

    protected function masaAsuransi($tenor)
    {
        if ($tenor <= 12) {
            $masaAsuransi = 1;
        } elseif ($tenor >= 13 && $tenor <= 24) {
            $masaAsuransi = 2;
        } else {
            $masaAsuransi = 3;
        }

        return $masaAsuransi;
    }

    public function hitungAngsuran(Request $request)
    {
        $danaDicairkan = $request->dana_dicairkan;
        $tenor = $request->tenor;
        $insurancePeriod = $this->masaAsuransi($tenor); 

        $angsuranPerBulan = ($danaDicairkan + 450000) * (1 + (0.25 / 12 * $tenor)) / $tenor;
        $angsuranPerBulan = ceil($angsuranPerBulan / 1000) * 1000; 

        return response()->json([
            'angsuran_per_bulan' => $angsuranPerBulan,
            'masa_asuransi' => $insurancePeriod
        ]);
    }

    public function list()
    {
        $specList = Spec::orderBy('name')->distinct('name')->get();
        return view('/users/detail', compact('specList'));
    }

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
                    return response()->json(['errorMessage' => 'Nama belum diisi'], 422);
                }
            
                if (empty($user->phone_number)) {
                    return response()->json(['errorMessage' => 'No. Handphone belum diisi'], 422);
                }

                $pinjamanDanaData = PinjamanDana::create([
                    'name' => $user->name,
                    'nohp' => $user->phone_number,
                    'tipe' => $request->input('tipe'),
                    'tipe_lain' => $request->input('tipeLain'),
                    'tahun' => $request->input('unit_tahun'),
                    'estimasi_harga' => $request->input('harga_motor'),
                    'want_dana' => $request->input('dana_dicairkan'),
                    'tenor' => $request->input('tenor'),
                    'estimasi_angsuran' => $request->input('angsuranMonthly'),
                    'id_user' => $user->id,
                ]);

                $messageBody = $this->buildMessageBody($request, $user);
            } else {
                $validateData = $request->validate([
                    'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
                    'nohp' => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
                ], [
                    'name.required'     => 'Nama belum diisi',
                    'name.regex'        => 'Gunakan huruf',
                    'name.max'          => 'Nama maksimal 50 karakter',
                    'nohp.required'     => 'No. Handphone belum diisi',
                    'nohp.numeric'      => 'Gunakan angka',
                    'nohp.regex'        => 'Mohon input No. Handphone dengan benar',
                ]);

                $pinjamanDanaData = PinjamanDana::create([
                    'name' => $validateData['name'],
                    'nohp' => $validateData['nohp'],
                    'tipe' => $request->input('tipe'),
                    'tipe_lain' => $request->input('tipeLain'),
                    'tahun' => $request->input('unit_tahun'),
                    'estimasi_harga' => $request->input('harga_motor'),
                    'want_dana' => $request->input('dana_dicairkan'),
                    'tenor' => $request->input('tenor'),
                    'estimasi_angsuran' => $request->input('angsuranMonthly'),
                ]);

                $messageBody = $this->buildMessageBodyContact($request, $validateData);
            }

            dd($messageBody);

            $apiResponse = $whatsAppController->sendWhatsAppMessage($phone, $messageBody);

            if ($apiResponse->getStatusCode() === 200) {
                return response()->json(['successMessage' => 'Pengajuan Anda telah diterima'], 201);
            } else {
                $pinjamanDanaData->delete();
                return response()->json(['errorMessage' => 'Pesan gagal terkirim!'], 422);
            }
        }
        
        return response()->json(['errorMessage' => 'Anda kemungkinan adalah bot'], 400);
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
        $messageBody[] = "Tenor: " . $request['tenor'] . ' Bulan';
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
        $messageBody[] = "Tenor: " . $request['tenor'] . ' Bulan';
        $messageBody[] = "Angsuran(Estimasi): " . 'Rp ' . number_format($request['angsuranMonthly'], 0, ',', '.');
        $messageBody[] = "Tolong segera diproses. Terima kasih.";
        
        return implode("\n", $messageBody);
    }
}
