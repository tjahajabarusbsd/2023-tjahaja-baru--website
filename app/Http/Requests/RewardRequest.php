<?php

namespace App\Http\Requests;

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
        return [
            'merchant_id' => 'nullable|exists:merchants,id',
            'title' => 'required|string|max:255',
            'image' => 'required',
            'point' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:0',
            'masa_berlaku_mulai' => 'nullable|date',
            'masa_berlaku_selesai' => 'nullable|date|after_or_equal:masa_berlaku_mulai',
            'deskripsi' => 'nullable|string',
            'terms_conditions' => 'nullable|string',
            'aktif' => 'boolean',
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
            //
        ];
    }
}
