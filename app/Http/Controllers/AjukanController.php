<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class AjukanController extends Controller
{
    public function ajukanAngsuran(Request $request)
    {

        // dd($request);
        $tipeMotor = $request->tipe;
        $tahunMotor = $request->unit_tahun;
        $hargaMotor = $request->harga_motor;
        $danaDicairkan = $request->dana_dicairkan;
        $tenor = $request->tenor;
        $otherProduct = $request->otherProduct;
        $angsuranMonthly = $request->angsuranMonthly;

        $body = "Ada calon Nasabah mengajukan dana tunai dari simulasi di website dengan informasi sebagai berikut:\n";
        $body .= "\n";
        if( $tipeMotor != 'other' ){
            $body .= "Tipe Motor: " . $tipeMotor;
        }
        
        if($otherProduct != null){
            $body .= "Tipe Motor: " . $otherProduct;
        }
        $body .= "\nTahun Motor: " . $tahunMotor;
        $body .= "\nHarga OTR(Estimasi): " . $hargaMotor;
        $body .= "\nNilai Diminta: " . $danaDicairkan;
        $body .= "\nTenor: " . $tenor;
        $body .= "\nAngsuran(Estimasi): " . $angsuranMonthly . "\n";
        $body .= "\n";
        $body .= "\nTolong segera diproses. Terima kasih.";

        // $phone = '08888';
        
        $data = [
            'phone' => $phone,
            'body' => $body,
        ];

        $token_wa = env('TOKEN_WA');

        $url = "https://api.1msg.io/434886/sendMessage?token=$token_wa";

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $client = new Client();
        $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        $successMessage = "Pengajuan Anda telah diterima";

        return response()->json(['successMessage' => $successMessage]);
    }
}
