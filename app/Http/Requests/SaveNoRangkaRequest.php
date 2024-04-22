<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SaveNoRangkaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nomor_rangka' => 'required|unique:nomor_rangkas,nomor_rangka|min:17',
        ];
    }

    public function messages()
    {
        return [
            'nomor_rangka.required' => 'Kolom wajib diisi.',
            'nomor_rangka.unique' => 'Nomor Rangka sudah digunakan.',
            'nomor_rangka.min' => 'Minimal 17 Karakter.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        return redirect()->back()->withErrors($validator->messages());
    }
}
