<?php

namespace App\Http\Requests;

class BookingServiceRequest extends BaseRequest
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
            'motor_id'  => 'required|exists:nomor_rangkas,id',
            'dealer_id' => 'required|integer',
            'tanggal'   => 'required|date',
            'jam'       => 'required',
        ];
    }

    public function messages()
    {
        return [
            'motor_id.required'  => 'Motor wajib dipilih.',
            'motor_id.exists'    => 'Motor yang dipilih tidak ditemukan atau tidak terdaftar.',
            'dealer_id.required' => 'Dealer wajib dipilih.',
            'dealer_id.integer'  => 'ID Dealer harus berupa angka.',
            'tanggal.required'   => 'Tanggal wajib diisi.',
            'tanggal.date'       => 'Format tanggal tidak valid. Gunakan format YYYY-MM-DD.',
            'jam.required'       => 'Jam servis wajib diisi.',
        ];
    }
}