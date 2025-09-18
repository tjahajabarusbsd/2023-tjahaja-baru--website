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
        $userId = auth()->user()->id;

        return [
            'full_name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s\'.-]+$/'],
            'gender' => ['nullable', 'in:L,P'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'photo_filename' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'email' => ['required', 'email', 'max:255', 'unique:user_publics,email,' . $userId],
            'phone' => ['required', 'string', 'regex:/^(\+62|62|0)8[1-9][0-9]{7,10}$/', 'unique:user_publics,phone_number,' . $userId],
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Nama wajib diisi.',
            'full_name.max' => 'Nama maksimal :max karakter.',
            'full_name.regex' => 'Nama hanya boleh berisi huruf, spasi, titik, tanda petik, atau tanda hubung.',
            'gender.in' => 'Jenis kelamin harus L (Laki-laki) atau P (Perempuan).',
            'birth_date.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
            'birth_date.before' => 'Tanggal lahir harus sebelum hari ini.',
            'photo_filename.image' => 'Foto profil harus berupa gambar.',
            'photo_filename.mimes' => 'Foto profil harus berformat jpg, jpeg, atau png.',
            'photo_filename.max' => 'Ukuran foto maksimal 2MB.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.required' => 'Nomor handphone wajib diisi.',
            'phone.string' => 'Nomor handphone harus berupa teks',
            'phone.regex' => 'Format nomor handphone tidak valid',
            'phone.unique' => 'Nomor handphone sudah digunakan.',
        ];
    }
}
