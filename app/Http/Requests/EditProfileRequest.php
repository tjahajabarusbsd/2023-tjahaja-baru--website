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
            'name' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tgl_lahir' => 'nullable|date',
            'foto_profil' => 'nullable|file|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
        ];
    }
}
