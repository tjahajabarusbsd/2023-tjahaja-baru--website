<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultationRequest extends FormRequest
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
            'name'   => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'nohp'   => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/'],
            'produk' => 'required',
            'g-recaptcha-response' => 'required',
            'terms'  => 'required|accepted'
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => 'Kolom wajib diisi.',
            'name.regex'       => 'Wajib menggunakan huruf.',
            'name.max'         => 'Nama maksimal 50 karakter.',
            'nohp.required'    => 'Kolom wajib diisi',
            'nohp.numeric'     => 'Wajib menggunakan angka.',
            'nohp.regex'       => 'Mohon input nomor HP dengan benar.',
            'produk.required'  => 'Kolom wajib diisi.',
            'g-recaptcha-response.required' => 'Captcha tidak valid',
            'terms.required'   => 'Kolom wajib dicentang.',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         redirect()->back()->withErrors($validator->errors())
    //     );
    // }
}
