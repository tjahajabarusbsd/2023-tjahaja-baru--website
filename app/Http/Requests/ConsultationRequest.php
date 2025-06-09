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
            'name'       => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'nohp'       => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/'],
            'produk'     => 'required',
            'cara_bayar' => 'required',
            'dp'         => 'required_if:cara_bayar,kredit', 
            'tenor'      => 'required_if:cara_bayar,kredit',
            'terms'      => 'required|accepted',
            'g-recaptcha-response' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama belum diisi',
            'name.regex'        => 'Gunakan huruf',
            'name.max'          => 'Nama maksimal 50 karakter',
            'nohp.required'     => 'No. Handphone belum diisi',
            'nohp.numeric'      => 'Gunakan angka',
            'nohp.regex'        => 'Mohon input No. Handphone dengan benar',
            'produk.required'   => 'Produk belum dipilih',
            'cara_bayar.required'  => 'Cara bayar belum dipilih',
            'dp.required_if'    => 'DP belum dipilih',
            'tenor.required_if' => 'Jumlah tenor belum dipilih',
            'terms.required'    => 'Kolom wajib dicentang',
            'g-recaptcha-response.required' => 'Captcha tidak valid. Mohon reload page.',
        ];
    }

    // public function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(
    //         redirect()->back()->withErrors($validator->errors())
    //     );
    // }
}
