<?php

namespace App\Http\Requests;

class EditProfileRequest extends BaseRequest
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
            'full_name' => 'required|string|max:255',
            'gender' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date_format:d/m/Y',
            'photo_filename' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Nama wajib diisi.',
        ];
    }
}
