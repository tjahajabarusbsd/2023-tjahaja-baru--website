<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string|exists:users,reset_password_token',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Password diperlukan.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus memiliki panjang minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'token.required' => 'Token diperlukan.',
            'token.string' => 'Token harus berupa teks.',
            'token.exists' => 'Token reset password tidak valid.',
        ];
    }
}