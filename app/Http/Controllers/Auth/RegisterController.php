<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Backpack\PermissionManager\app\Models\Role;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Verifikasi reCAPTCHA
        $recaptchaResponse = RecaptchaV3::verify($request->input('g-recaptcha-response'), 'register_captcha');
        
        if ($recaptchaResponse > 0.7) {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas yang valid (skor tinggi)
            // Lanjutkan dengan proses form
        } elseif ($recaptchaResponse > 0.3) {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas mencurigakan (skor sedang)
            // Memerlukan verifikasi email tambahan atau langkah-langkah lainnya
        } else {
            // Tindakan yang sesuai jika reCAPTCHA v3 menunjukkan aktivitas yang mencurigakan (skor rendah)
            return redirect('register')
                ->withErrors(['g-recaptcha-response' => 'Anda kemungkinan besar adalah bot'])
                ->withInput();
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->create($request->all());

        $memberRole = Role::where('name', 'member_website')->first();
        $user->assignRole($memberRole);

        Auth::login($user);

        return redirect()->route('user.profile');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'phone_number' => [
                'required',
                'numeric',
                'regex:/^08[1-9][0-9]{6,10}$/',
                'unique:users,phone_number', // Tambahkan aturan unik di sini jika diperlukan
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.max' => 'Kolom nama tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Wajib menggunakan huruf.',
            'phone_number.required' => 'Kolom nomor handphone wajib diisi.',
            'phone_number.numeric' => 'Kolom nomor handphone harus berupa angka.',
            'phone_number.regex' => 'Format nomor handphone tidak valid. Pastikan diawali dengan 08 dan maksimal 13 digit',
            'phone_number.unique' => 'Nomor handphone sudah digunakan.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa teks.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ]);
    }
}