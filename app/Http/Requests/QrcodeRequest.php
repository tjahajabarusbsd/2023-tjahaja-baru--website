<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'merchant_id' => 'nullable|exists:merchants,id',
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
            'merchant_id.exists' => 'Merchant tidak valid',
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
