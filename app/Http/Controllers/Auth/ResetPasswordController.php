<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use App\User;

class ResetPasswordController extends Controller
{
    public function resetPasswordForm($token)
    {
        $user = User::where('reset_password_token', $token)
                    ->first();

        if ($user) {
            return view('auth.reset-password', ['token' => $token]);
        } else {
            return redirect()->route('login')->with('error', 'Token reset password tidak valid atau sudah kedaluwarsa.');
        }
    }

    public function updatePassword(ResetPasswordRequest $request)
    {
        $user = User::where('reset_password_token', $request->token)
                    ->first();

        if ($user) {
            $user->password = bcrypt($request->password);
            $user->reset_password_token = null;
            $user->save();

            return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan masuk dengan password baru Anda.');
        } else {
            return redirect()->route('login')->with('error', 'Token reset password tidak valid atau sudah kedaluwarsa.');
        }
    }
}