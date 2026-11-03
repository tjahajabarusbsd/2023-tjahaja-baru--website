<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'kode_dealer' => 'nullable|string|max:50',
            'name_dealer' => 'required|string|max:255',
            'kecamatan'   => 'nullable|string|max:255',
            'kota'        => 'nullable|string|max:255',
            'address'     => 'nullable|string',
            'nohp'        => 'nullable|string|max:50',
            'latitude'    => 'nullable|numeric|between:-90,90',
            'longitude'   => 'nullable|numeric|between:-180,180',
        ];
    }

    public function attributes()
    {
        return [
            'name_dealer' => 'nama dealer',
            'nohp'        => 'nomor HP',
        ];
    }

    public function messages()
    {
        return [
            'latitude.numeric'  => 'Latitude harus berupa angka, contoh: -0.9492',
            'longitude.numeric' => 'Longitude harus berupa angka, contoh: 100.3543',
        ];
    }
}
