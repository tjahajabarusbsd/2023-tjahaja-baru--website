<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use App\Models\Staff;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use GuzzleHttp\Client;

class WhatsAppController extends Controller
{
    public function sendMessage(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name'   => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'nohp'   => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'produk' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'name.required'   => 'Kolom wajib diisi.',
            'name.regex'      => 'Wajib menggunakan huruf.',
            'name.max'        => 'Nama maksimal 50 karakter.',
            'nohp.required'   => 'Kolom wajib diisi',
            'nohp.numeric'    => 'Wajib menggunakan angka.',
            'nohp.regex'      => 'Mohon input nomor HP dengan benar.',
            'produk.required' => 'Kolom wajib diisi.',
            'g-recaptcha-response.required' => 'captcha error'
        ]);

        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'consultation');
        // $score = 0.0;
        if ($score > 0.7) {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas yang valid (skor tinggi)
            // Lanjutkan dengan proses form
        } elseif ($score > 0.3) {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas mencurigakan (skor sedang)
            // Memerlukan verifikasi email tambahan atau langkah-langkah lainnya
        } else {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas yang mencurigakan (skor rendah)
            return abort(400, 'Anda kemungkinan besar adalah bot');
        }

        // Get sales code
        $salesCode = $request->input('sales');
        // Get the current URL path
        $currentURL = $request->input('url');
        // Extract characters after the last '/'
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

        $name = $request->input('name');
        $nohp = $request->input('nohp');
        $selectedOption = $request->input('produk');

        // Whatsapp body
        $body = "Hi, Dealer,\n";
        $body .= "Berikut ini data konsumen yang mengisi form di website kita yang minat dengan produk Yamaha:\n";
        $body .= "\nNama: " . $name;
        $body .= "\nNo HP: " . $nohp;
        $body .= "\nProduk yang diminati: " . $selectedOption . "\n";
        $body .= "\nMohon segera diproses. Terima kasih.";

        $data = [
            'phone' => $phone,
            'body' => $body,
        ];

        dd($body, $phone);

        $url = "https://api.1msg.io/434886/sendMessage?token=off_qEkYX33795ARuvTqG38zxXYbAK";

        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $client = new Client();
        $client->post($url, [
            'headers' => $headers,
            'json' => $data,
        ]);

        // Save to db
        $save_consultation_data = new Consultation();
        $save_consultation_data->name = $request->input('name');
        $save_consultation_data->nohp = $request->input('nohp');
        $save_consultation_data->product = $request->input('produk');
        $save_consultation_data->url = $charactersAfterLastSlash;
        $save_consultation_data->sales_code = $salesCode;
        $save_consultation_data->save();

        $successMessage = "Pengajuan Anda telah diterima.\nDealer kami akan segera menghubungi Anda.";

        return redirect()->back()->with('success', $successMessage);
    }
}
