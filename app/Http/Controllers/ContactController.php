<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactformMail;

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
}
