<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function resetPasswordForm($token)
    {
        // Cari pengguna dengan token yang sesuai
        $user = User::where('reset_password_token', $token)
                    ->first();
        // dd($user);
        // Jika pengguna ditemukan dan token belum kedaluwarsa
        if ($user) {
            return view('auth.reset-password', ['token' => $token]);
        } else {
            // Token tidak valid atau sudah kedaluwarsa
            return redirect()->route('login')->with('error', 'Token reset password tidak valid atau sudah kedaluwarsa.');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string|exists:users,reset_password_token',
        ], [
            'password.required' => 'Password diperlukan.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus memiliki panjang minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'token.required' => 'Token diperlukan.',
            'token.string' => 'Token harus berupa teks.',
            'token.exists' => 'Token reset password tidak valid.',
        ]);  
        
        // Cari pengguna dengan token yang sesuai
        $user = User::where('reset_password_token', $request->token)
                    ->first();
        
        // Jika pengguna ditemukan dan token belum kedaluwarsa
        if ($user) {
            // Update password pengguna
            $user->password = bcrypt($request->password);
            $user->reset_password_token = null;
            $user->save();

            return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan masuk dengan password baru Anda.');
        } else {
            // Token tidak valid atau sudah kedaluwarsa
            return redirect()->route('login')->with('error', 'Token reset password tidak valid atau sudah kedaluwarsa.');
        }
    }
}
