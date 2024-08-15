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
            'cara_bayar' => 'required',
            'dp' => 'required_if:cara_bayar,kredit', 
            'tenor' => 'required_if:cara_bayar,kredit',
            'g-recaptcha-response' => 'required',
            'terms'  => 'required|accepted'
        ];
    }

    public function messages()
    {
        return [
            'name.required'    => 'Nama wajib diisi.',
            'name.regex'       => 'Wajib menggunakan huruf.',
            'name.max'         => 'Nama maksimal 50 karakter.',
            'nohp.required'    => 'Nomor HP wajib diisi.',
            'nohp.numeric'     => 'Wajib menggunakan angka.',
            'nohp.regex'       => 'Mohon input nomor HP dengan benar.',
            'produk.required'  => 'Silakan pilih produk yang diminati.',
            'cara_bayar.required'  => 'Silakan pilih cara bayar.',
            'dp.required'      => 'Silakan pilih down payment.',
            'tenor.required'   => 'Silakan pilih jumlah tenor.',
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
