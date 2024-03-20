<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Backpack\PermissionManager\app\Models\Role;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->create($request->all());

        $memberRole = Role::where('name', 'member_website')->first();
        $user->assignRole($memberRole);

        Auth::login($user);

        return redirect('/user-profile');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'max:50', 'regex:/^[a-zA-Z\s]+$/'],
            'phone_number' => [
                'required',
                'numeric',
                'regex:/^(\+62|62|0)8[1-9][0-9]{6,10}$/',
                'unique:users,phone_number', // Tambahkan aturan unik di sini jika diperlukan
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Kolom nama wajib diisi.',
            'name.string' => 'Kolom nama harus berupa teks.',
            'name.max' => 'Kolom nama tidak boleh lebih dari :max karakter.',
            'name.regex' => 'Wajib menggunakan huruf.',
            'phone_number.required' => 'Kolom nomor telepon wajib diisi.',
            'phone_number.numeric' => 'Kolom nomor telepon harus berupa angka.',
            'phone_number.regex' => 'Format nomor telepon tidak valid.',
            'phone_number.unique' => 'Nomor telepon sudah digunakan.',
            'password.required' => 'Kolom password wajib diisi.',
            'password.string' => 'Kolom password harus berupa teks.',
            'password.min' => 'Password minimal harus :min karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
        ]);
    }
}