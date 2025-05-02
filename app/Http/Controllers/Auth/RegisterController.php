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
        if (!in_array($type, ['google', 'phone'])) {
            abort(404);
        }
        if ($type == 'google') {
            return Socialite::driver('google')->redirect();
        } elseif ($type == 'phone') {
            return view('');
        } else {
            abort(404);
        }
    }
    public function register(Request $request, $type)
    {
        try {
            $googleUser = Socialite::driver($type)->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to login with Google.');
        }

        $user = $this->user->where('email', $googleUser->email)->first();

        if (!$user) {
            $user = $this->user->create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'password' => Hash::make(Str::random(12)),
                'role_id' => $this->user::USER,
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        if ($user->role_id == $this->user::USER) {
            return redirect('/user/dashboard')->with('success', 'Login berhasil.');
        } elseif ($user->role_id == $this->user::ADMIN) {
            return redirect('/admin/dashboard')->with('success', 'Login berhasil.');
        } elseif ($user->role_id == $this->user::SUPER_ADMIN) {
            return redirect('/super-admin/dashboard')->with('success', 'Login berhasil.');
        } else {
            return redirect('/')->with('success', 'Login berhasil.');
        }
    }
}
