<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VariantRequest extends FormRequest
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
            'name' => 'required',
            // 'image' => 'required',
            'color' => 'required',
            'color_name' => 'required',
            'price' => 'required'
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
            'name.required' => 'Name tidak boleh kosong.',
            // 'image.required' => 'Image tidak boleh kosong.',
            'color.required' => 'Color tidak boleh kosong.',
            'color_name.required' => 'Color Name tidak boleh kosong.',
            'price.required' => 'Price tidak boleh kosong.',
        ];
    }
}
