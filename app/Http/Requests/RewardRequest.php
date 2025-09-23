<?php

namespace App\Http\Requests;

use App\Models\Reward;
use Illuminate\Foundation\Http\FormRequest;

class RewardRequest extends FormRequest
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
        $rules = [
            'merchant_id' => 'required|exists:merchants,id',
            'type' => 'required|in:' . implode(',', array_keys(Reward::TYPES)),
            'title' => 'required|string|max:255',
            'aktif' => 'boolean',
            'discount_type' => 'required|string|in:' . implode(',', array_keys(Reward::DISCOUNT_TYPES)),
            'discount_value' => 'required|integer|min:0',
            'masa_berlaku_mulai' => 'required|date',
            'masa_berlaku_selesai' => 'required|date|after_or_equal:masa_berlaku_mulai',
        ];

        if ($this->input('type') === 'public') {
            $rules = array_merge($rules, [
                'image' => 'required',
                'point' => 'required|integer|min:0',
                'quantity' => 'required|integer|min:0',
                'deskripsi' => 'required|string',
                'terms_conditions' => 'required|string',
            ]);
        }

        return $rules;
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
            'merchant_id.required' => 'Merchant wajib diisi.',
            'title.required' => 'Nama reward wajib diisi.',
            'type.required' => 'Tipe reward wajib diisi.',
            'image.required' => 'Gambar reward wajib diunggah.',
            'point.required' => 'Poin reward wajib diisi.',
            'point.integer' => 'Poin reward harus berupa angka.',
            'quantity.required' => 'Kuantitas reward wajib diisi.',
            'quantity.integer' => 'Kuantitas reward harus berupa angka.',
            'discount_value.required' => 'Nilai diskon wajib diisi.',
            'masa_berlaku_mulai.required' => 'Masa berlaku mulai wajib diisi.',
            'masa_berlaku_mulai.date' => 'Masa berlaku mulai tidak valid.',
            'masa_berlaku_selesai.required' => 'Masa berlaku selesai wajib diisi.',
            'masa_berlaku_selesai.date' => 'Masa berlaku selesai tidak valid.',
            'deskripsi.required' => 'Deskripsi reward wajib diisi.',
            'terms_conditions.required' => 'Syarat & Ketentuan reward wajib diisi.',
            'aktif.boolean' => 'Status aktif tidak valid.',
            'type.in' => 'Tipe reward tidak valid.',
        ];
    }
}
