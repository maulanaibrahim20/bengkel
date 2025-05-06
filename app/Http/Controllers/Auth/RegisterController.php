<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\EmailOtpNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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
        return view('auth.register.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|same:password_confirmation',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $token = Str::random(10);

            $user = $this->user->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $this->user::USER,
                'status' => 0,
                'remember_token' => $token,
            ]);

            $user->notify(new VerifyEmailNotification($token));

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['message' => 'Register berhasil. Silakan cek email untuk verifikasi.']);
            }

            return redirect('/login')->with('success', 'Register berhasil. Silakan cek email untuk verifikasi.');
        } catch (\Exception $e) {
            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => 'Register gagal. ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Register gagal. ' . $e->getMessage());
        }
    }

    public function verifyEmail($token)
    {
        $user = $this->user->where('remember_token', $token)->first();

        if (!$user) {
            return redirect('/login')->with('error', 'Token tidak valid atau sudah digunakan.');
        }

        $user->update([
            'email_verified_at' => now(),
            'status' => 1
        ]);

        return redirect('/login')->with('success', 'Email berhasil diverifikasi. Silakan login.');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function register(Request $request, $provider)
    {
        try {
            $googleUser = Socialite::driver($provider)->user();

            if (!$googleUser || !$googleUser->email) {
                return redirect('/login')->with('error', 'Tidak dapat mengambil data dari Google.');
            }

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
                ]);

                session(['new_register' => true]);
            }

            Auth::login($user);
            $request->session()->regenerate();

            if (!Auth::check()) {
                return back()->with('error', 'Autentikasi gagal. Silakan coba lagi.');
            }

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
            Log::error('Google Login Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal login menggunakan ' . $e->getMessage());
        }
    }
}
