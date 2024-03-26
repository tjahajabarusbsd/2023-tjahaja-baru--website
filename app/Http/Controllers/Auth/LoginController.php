<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Library\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login'); // Customize the login form view
    }

    public function username()
    {
        return 'phone_number';
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => [
                'required',
                'numeric',
            ],
            'password' => 'required|string',
        ], [
            $this->username() . '.numeric' => 'Nomor telepon harus berupa angka.',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();

        if (!$user || !\Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                $this->username() => 'Nomor telepon tidak terdaftar atau password tidak cocok.',
            ]);
        }

        // Customize the login attempt logic if needed
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function authenticated(Request $request, $user)
    {
        // Customize the actions after a user is authenticated
        // For example, redirect to a specific page
        return redirect('/user-profile');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success','You have logged out!');
    }  

    public function redirectToGoogle()
    {
        // return Socialite::driver('google')->redirect();
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback(\Request $request)
    {
        try {
            // $googleUser = Socialite::driver('google')->user();
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {
                // Jika pengguna belum ada, buat pengguna baru
                $user = new User();
                $user->name = $googleUser->name;
                $user->email = $googleUser->email;
                $user->password = 0;
                $user->google_id = $googleUser->id;
                // Setel kolom-kolom lainnya sesuai kebutuhan.
                $user->save();
                
                // Tambahkan peran 'member_website'
                $user->assignRole('member_website');
            }

            Auth::login($user);
        
            return redirect('/user-profile');

        } catch (\Exception $e) {
            return redirect()->route('login');
        }
    }
}