<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MerchantRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'image' => 'required',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string',
            'aktif' => 'boolean',
            'is_internal' => 'boolean',
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
            'title.required' => 'Nama merchant wajib diisi.',
            'image.required' => 'Gambar merchant wajib diisi.',
            'deskripsi.required' => 'Deskripsi merchant wajib diisi.',
            'lokasi.required' => 'Lokasi merchant wajib diisi.',
        ];
    }
}
