<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return view('auth.register.choose_register');
    }

    public function showForm($type)
    {
        switch ($type) {
            case 'google':
                return Socialite::driver('google')->redirect();
            case 'phone':
                return view('');
            default:
                abort(404);
        }
    }

    public function register(Request $request, $type)
    {
        try {
            $googleUser = Socialite::driver($type)->user();

            $user = $this->user->where('email', $googleUser->email)->first();

            if (!$user) {
                $user = $this->user->create([
                    'name'              => $googleUser->name,
                    'email'             => $googleUser->email,
                    'password'          => Hash::make(Str::random(12)),
                    'role_id'           => $this->user::USER,
                    'email_verified_at' => now(),
                    'remember_token'    => Str::random(10),
                    'profile_image'     => $googleUser->avatar,
                    'gender'            => $request
                ]);

                session(['new_register' => true]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            switch ($user->role_id) {
                case $this->user::USER:
                    return session('new_register')
                        ? redirect('/user/update/profile')->with('success', 'Login berhasil.')
                        : redirect('/user/welcome')->with('success', 'Login berhasil.');

                case $this->user::ADMIN:
                    return redirect('/admin/dashboard')->with('success', 'Login berhasil.');

                case $this->user::SUPER_ADMIN:
                    return redirect('/super-admin/dashboard')->with('success', 'Login berhasil.');

                default:
                    return redirect('/')->with('success', 'Login berhasil.');
            }
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login menggunakan ' . ucfirst($type) . '.');
        }
    }
}
