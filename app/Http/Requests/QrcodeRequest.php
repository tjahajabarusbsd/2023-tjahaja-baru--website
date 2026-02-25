<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Qrcode;

class QrcodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_qrcode' => 'required|min:3',
            'merchant_id' => 'required|exists:merchants,id',
            'promo_id' => 'required|exists:promos,id',
            'jenis_kerjasama' => [
                'required',
                Rule::in([
                    Qrcode::KERJASAMA_MERCHANT,
                    Qrcode::KERJASAMA_TB,
                    Qrcode::KERJASAMA_COST_SHARING
                ])
            ],
            'tipe_hadiah' => [
                'required',
                Rule::in([
                    Qrcode::HADIAH_DIRECT,
                    Qrcode::HADIAH_UNDIAN
                ])
            ],

            'tipe_qr' => [
                'required',
                Rule::in([
                    Qrcode::TIPE_KODE,
                    Qrcode::TIPE_LINK
                ])
            ],
            'redirect_url' => 'required_if:tipe_qr,link|nullable|url',
            'tb_percentage' => 'nullable|required_if:jenis_kerjasama,cost_sharing|numeric|min:0|max:100',
            'merchant_percentage' => 'nullable|required_if:jenis_kerjasama,cost_sharing|numeric|min:0|max:100',
            'benefit' => 'required',
            'nominal' => 'numeric|min:0',
            'masa_berlaku_mulai' => 'required|date',
            'masa_berlaku_selesai' => 'required|date|after:masa_berlaku_mulai',
            'jam_mulai' => 'nullable|required_with:jam_selesai|date_format:H:i',
            'jam_selesai' => 'nullable|required_with:jam_mulai|date_format:H:i|after:jam_mulai',
            'max_penggunaan' => 'nullable|integer|min:1'
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
            'nama_qrcode.required' => 'Nama QR code wajib diisi',
            'nama_qrcode.min' => 'Nama QR code minimal 3 karakter',
            'merchant_id.required' => 'Merchant wajib dipilih',
            'merchant_id.exists' => 'Merchant tidak valid',
            'promo_id.required' => 'Promo wajib dipilih',
            'promo_id.exists' => 'Promo tidak valid',
            'jenis_kerjasama.required' => 'Jenis kerjasama wajib diisi',
            'jenis_kerjasama.in' => 'Jenis kerjasama tidak valid',
            'tipe_hadiah.required' => 'Tipe hadiah wajib diisi',
            'tipe_hadiah.in' => 'Tipe hadiah tidak valid',
            'tipe_qr.required' => 'Tipe QR code wajib diisi',
            'tipe_qr.in' => 'Tipe QR code tidak valid',
            'redirect_url.required_if' => 'Redirect URL wajib diisi jika tipe QR adalah Link',
            'redirect_url.url' => 'Redirect URL harus berupa URL yang valid',
            'tb_percentage.required_if' => 'TB Percentage wajib diisi jika jenis kerjasama adalah Cost Sharing',
            'tb_percentage.numeric' => 'TB Percentage harus berupa angka',
            'tb_percentage.min' => 'TB Percentage minimal 0',
            'tb_percentage.max' => 'TB Percentage maksimal 100',
            'merchant_percentage.required_if' => 'Merchant Percentage wajib diisi jika jenis kerjasama adalah Cost Sharing',
            'merchant_percentage.numeric' => 'Merchant Percentage harus berupa angka',
            'merchant_percentage.min' => 'Merchant Percentage minimal 0',
            'merchant_percentage.max' => 'Merchant Percentage maksimal 100',
            'benefit.required' => 'Hadiah/Benefit wajib diisi',
            'nominal.numeric' => 'Nominal harus berupa angka',
            'nominal.min' => 'Nominal minimal 0',
            'masa_berlaku_mulai.required' => 'Masa berlaku mulai wajib diisi',
            'masa_berlaku_mulai.date' => 'Masa berlaku mulai harus berupa tanggal yang valid',
            'masa_berlaku_selesai.required' => 'Masa berlaku selesai wajib diisi',
            'masa_berlaku_selesai.date' => 'Masa berlaku selesai harus berupa tanggal yang valid',
            'masa_berlaku_selesai.after' => 'Masa berlaku selesai harus setelah masa berlaku mulai',
            'jam_mulai.required_with' => 'Jam mulai wajib diisi jika jam selesai diisi',
            'jam_mulai.date_format' => 'Jam mulai harus dalam format HH:mm',
            'jam_selesai.required_with' => 'Jam selesai wajib diisi jika jam mulai diisi',
            'jam_selesai.date_format' => 'Jam selesai harus dalam format HH:mm',
            'jam_selesai.after' => 'Jam selesai harus setelah jam mulai',
            'max_penggunaan.integer' => 'Max penggunaan harus berupa angka',
            'max_penggunaan.min' => 'Max penggunaan minimal 1'
        ];
    }
}
