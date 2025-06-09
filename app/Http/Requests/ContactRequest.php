<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ContactRequest extends FormRequest
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
            'name'    => 'required|max:50|regex:/^[a-zA-Z\s]+$/',
            'nohp'    => ['required', 'numeric', 'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/'],
            'message' => 'required',
            'g-recaptcha-response' => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'    => 'Nama belum diisi',
            'name.regex'       => 'Gunakan huruf',
            'name.max'         => 'Nama maksimal 50 karakter',
            'nohp.required'    => 'No. Handphone belum diisi',
            'nohp.numeric'     => 'Gunakan angka',
            'nohp.regex'       => 'Mohon input No. Handphone dengan benar',
            'message.required' => 'Tulis pesan Anda',
            'g-recaptcha-response.required' => 'captcha error'
        ];
    }
}
