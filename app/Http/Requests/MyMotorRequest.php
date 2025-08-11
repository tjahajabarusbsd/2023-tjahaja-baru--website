<?php

namespace App\Http\Requests;

class MyMotorRequest extends BaseRequest
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
            'nomor_rangka' => [
                'required',
                'string',
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/',
            ],
            'ktp' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
            'kk' => 'required|file|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nomor_rangka.required' => 'Nomor rangka wajib diisi.',
            'nomor_rangka.string' => 'Nomor rangka harus berupa teks.',

            'phone_number.required' => 'Nomor handphone wajib diisi.',
            'phone_number.string' => 'Nomor handphone harus berupa teks.',
            'phone_number.regex' => 'Format nomor handphone tidak valid.',

            'ktp.required' => 'Foto KTP wajib diunggah.',
            'ktp.file' => 'KTP harus berupa file.',
            'ktp.image' => 'File KTP harus berupa gambar.',
            'ktp.mimes' => 'KTP harus berformat JPG, JPEG, atau PNG.',
            'ktp.max' => 'Ukuran file KTP maksimal 2MB.',

            'kk.required' => 'Foto KK wajib diunggah.',
            'kk.file' => 'KK harus berupa file.',
            'kk.image' => 'File KK harus berupa gambar.',
            'kk.mimes' => 'KK harus berformat JPG, JPEG, atau PNG.',
            'kk.max' => 'Ukuran file KK maksimal 2MB.',
        ];
    }
}
