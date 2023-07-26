<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactformMail;
use App\Models\Contact;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class ContactController extends Controller
{
    public function getContactForm()
    {
        return view('contact');
    }

    public function postContactForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name'    => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'nohp'    => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'message' => 'required'
        ], [
            'name.required'    => 'Kolom wajib diisi.',
            'name.regex'       => 'Wajib menggunakan huruf.',
            'nohp.required'    => 'Kolom wajib diisi',
            'nohp.numeric'     => 'Wajib menggunakan angka.',
            'nohp.regex'       => 'Mohon input nomor HP dengan benar.',
            'message.required' => 'Kolom wajib diisi.',
        ]);

        // $input = $request->input();
        // dd($input);

        $email = env('MAIL_TO_ADDRESS');

        // Send email
        Mail::to($email)->send(new ContactformMail($request));

        // Redirect the user after sending the email
        return redirect()->back()->with('success', 'Terima kasih data Anda sudah berhasil terkirim!');
    }

    public function submitContactForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name'    => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'nohp'    => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'message' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'name.required'    => 'Kolom wajib diisi.',
            'name.regex'       => 'Wajib menggunakan huruf.',
            'nohp.required'    => 'Kolom wajib diisi',
            'nohp.numeric'     => 'Wajib menggunakan angka.',
            'nohp.regex'       => 'Mohon input nomor HP dengan benar.',
            'message.required' => 'Kolom wajib diisi.',
            'g-recaptcha-response.required' => 'captcha error'
        ]);

        $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
        // $score = 0.0;
        if ($score > 0.7) {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas yang valid (skor tinggi)
            // Lanjutkan dengan proses form
            $data = new Contact();
            $data->name = $request->input('name');
            $data->nohp = $request->input('nohp');
            $data->message = $request->input('message');
            $data->save();

            return redirect()->back()->with('success', 'Terima kasih data Anda sudah berhasil terkirim!');
        } elseif ($score > 0.3) {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas mencurigakan (skor sedang)
            // Memerlukan verifikasi email tambahan atau langkah-langkah lainnya
            return abort(400, 'Anda kemungkinan besar adalah bot');
        } else {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas yang mencurigakan (skor rendah)
            return abort(400, 'Anda kemungkinan besar adalah bot');
        }
    }
}
