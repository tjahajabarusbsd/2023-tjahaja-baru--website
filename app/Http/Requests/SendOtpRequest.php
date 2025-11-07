<?php

namespace App\Http\Requests;

class SendOtpRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'type' => ['required', 'in:register,lupa_password'],
        ];
    }

    public function messages()
    {
        return [
            'phone_number.required' => 'Nomor handphone wajib diisi',
            'phone_number.string' => 'Nomor handphone harus berupa teks',
            'phone_number.regex' => 'Format nomor handphone tidak valid',
            'type.required' => 'Tipe permintaan OTP wajib diisi',
            'type.in' => 'Tipe permintaan OTP tidak valid',
        ];
    }
}
