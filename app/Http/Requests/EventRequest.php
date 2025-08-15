<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\Event;

class EventRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'image' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:' . implode(',', array_keys(Event::TYPES)),
            'is_active' => 'boolean',
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
            'name' => 'Nama Event',
            'description' => 'Deskripsi',
            'image' => 'Gambar',
            'start_date' => 'Tanggal Mulai',
            'end_date' => 'Tanggal Selesai',
            'type' => 'Jenis Event',
            'is_active' => 'Status Aktif',
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
            'name.required' => 'Nama event wajib diisi.',
            'description.required' => 'Deskripsi event wajib diisi.',
            'image.required' => 'Gambar event wajib diunggah.',
            // 'image.image' => 'File yang diunggah harus berupa gambar.',
            // 'image.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
            'start_date.required' => 'Tanggal mulai harus diisi.',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'end_date.required' => 'Tanggal selesai harus diisi.',
            'type.required' => 'Jenis event harus dipilih.',
            'type.in' => 'Jenis event harus salah satu dari: ' . implode(', ', array_keys(Event::TYPES)),
        ];
    }
}