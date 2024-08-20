<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class SkySubmissionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sky_name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'sky_phone_number' => ['nullable', 'numeric', 'regex:/^(\62|0)8[1-9][0-9]{6,10}$/', 'unique:users,phone_number,'.$this->user()->id],
            'sky_alamat' => ['required', 'string', 'max:100'],
            'sky_tipe' => ['required', 'string', 'max:12'],
            'sky_kendala' => ['required', 'string', 'max:100'],
        ];
    }

    public function messages()
    {
        return [
            'sky_name.required' => 'Nama wajib diisi.',
            'sky_name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'sky_name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'sky_phone_number.numeric' => 'Nomor HP harus berupa karakter numerik.',
            'sky_phone_number.regex' => 'Format nomor telepon tidak valid.',
            'sky_phone_number.unique' => 'Nomor handphone sudah digunakan.',
            'sky_alamat.required' => 'Alamat wajib diisi.',
            'sky_alamat.max' => 'Alamat tidak boleh lebih dari :max karakter.',
            'sky_tipe.required' => 'Tipe motor wajib diisi.',
            'sky_tipe.max' => 'Tipe tidak boleh lebih dari :max karakter.',
            'sky_kendala.required' => 'Kendala wajib diisi.',
            'sky_kendala.max' => 'Tidak boleh lebih dari :max karakter.',
        ];
    }

}
