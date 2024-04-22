<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'unique:users,email,'.$this->user()->id],
            'phone_number' => ['nullable', 'numeric', 'regex:/^(\62|0)8[1-9][0-9]{6,10}$/', 'unique:users,phone_number,'.$this->user()->id],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'phone_number.numeric' => 'Nomor HP harus berupa karakter numerik.',
            'phone_number.regex' => 'Format nomor telepon tidak valid.',
            'phone_number.unique' => 'Nomor handphone sudah digunakan.'
        ];
    }
}
