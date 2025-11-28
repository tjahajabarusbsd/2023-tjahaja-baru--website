<?php

namespace App\Http\Requests;

class OrderMotorRequest extends BaseRequest
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
            'variant_id' => 'required|exists:variants,id',
            'model' => 'required|string',
            'warna' => 'required|string',
            'tipe_pembayaran' => 'required|in:kredit,cash',
            'setuju_dihubungi' => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'variant_id.required' => 'Varian motor wajib dipilih',
            'variant_id.exists' => 'Varian motor tidak ditemukan',
            'model.required' => 'Model wajib diisi',
            'model.string' => 'Model harus berupa teks',
            'warna.required' => 'Warna wajib diisi',
            'warna.string' => 'Warna harus berupa teks',
            'tipe_pembayaran.required' => 'Tipe pembayaran wajib dipilih',
            'tipe_pembayaran.in' => 'Tipe pembayaran harus kredit atau cash',
            'setuju_dihubungi.accepted' => 'Anda harus menyetujui untuk dihubungi',
        ];
    }
}
