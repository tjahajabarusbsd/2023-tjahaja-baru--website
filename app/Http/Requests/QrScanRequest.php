<?php

namespace App\Http\Requests;

class QrScanRequest extends BaseRequest
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
            'qr_code' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'qr_code.required' => 'Qr Code wajib diisi',
            'qr_code.string' => 'Qr Code harus berupa teks',
        ];
    }
}
