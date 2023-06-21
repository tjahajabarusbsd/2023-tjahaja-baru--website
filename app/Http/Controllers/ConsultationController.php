<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationformMail;
use App\Models\Variant;

class ConsultationController extends Controller
{
    public function getConsultationForm(Request $request)
    {
        $value = $request->query('sales');
        $lists = Variant::all()->unique('name');

        return view('consultation', compact('value', 'lists'));
    }

    public function postConsultationForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name'   => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'nohp'   => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'produk' => 'required'
        ], [
            'name.required'   => 'Kolom wajib diisi.',
            'name.regex'      => 'Wajib menggunakan huruf.',
            'name.max'        => 'Nama maksimal 50 karakter.',
            'nohp.required'   => 'Kolom wajib diisi',
            'nohp.numeric'    => 'Wajib menggunakan angka.',
            'nohp.regex'      => 'Mohon input nomor HP dengan benar.',
            'produk.required' => 'Kolom wajib diisi.',
        ]);

        // Check dealer
        if (!empty($request->dealer) && $request->dealer == 'ydstb') {
            $email = 'mauizatul92+1@gmail.com';
        } else {
            $email = 'mauizatul92@gmail.com';
        }
        dd($email);
        // Send email
        Mail::to($email)->send(new ConsultationformMail($request));

        // Redirect the user after sending the email
        return redirect()->back()->with('success', 'Terima kasih data Anda sudah berhasil terkirim!');
    }
}
