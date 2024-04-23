<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\User;
use GuzzleHttp\Client;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password'); // Customize the login form view
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone_number' => [
                'required',
                'numeric',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/',
                function ($attribute, $value, $fail) {
                    // $value = preg_replace('/^(\+62|62)/', '0', $value);
                    $user = User::where('phone_number', $value)->first();
                    if (!$user) {
                        $fail('Nomor telepon tidak terdaftar.');
                    }
                },
            ],
        ], [
            'phone_number.required' => 'Kolom nomor telepon wajib diisi.',
            'phone_number.numeric' => 'Kolom nomor telepon harus berupa angka.',
            'phone_number.regex' => 'Format nomor telepon tidak valid.',
        ]);
    }

    public function sendLinkResetPassword(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('phone_number', $request->phone_number)->first();
        
        $baseURL = config('app.url');
        
        if($user) {
            $phone_tujuan = $request->phone_number;
            if (substr($phone_tujuan, 0, 1) === '0') {
                $phone_tujuan = '62' . substr($phone_tujuan, 1);
            }
            
            $token = Str::random(60);
            $user->reset_password_token = $token;
            $user->save();

            $body = "Link Reset password: $baseURL/reset-password/$token";

            $data = [
                'phone' => $phone_tujuan,
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

            $successMessage = "Link reset password berhasil dikirim.";

            return redirect()->back()->with('success', $successMessage);
        } else {
            return back()->withErrors(['phone_number' => 'Nomor telepon tidak terdaftar.']);
        }

    }

}