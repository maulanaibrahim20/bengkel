<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function index(Request $request)
    {
        return view('auth.login.index');
    }

    public function login(Request $request)
    {
        DB::beginTransaction();
        $validate = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails()) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'errors' => $validate->errors(),
            ], 422);
        }

        try {
            $user = $this->user->where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                DB::rollBack();
                return response()->json(['status' => false, 'message' => 'Email atau password salah.'], 401);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $request->session()->regenerate();

                DB::commit();

                if ($user->role_id == $this->user::SUPER_ADMIN) {
                    $redirectUrl = url('/super-admin/dashboard');
                } elseif ($user->role_id == $this->user::ADMIN) {
                    $redirectUrl = url('/admin/dashboard');
                } elseif ($user->role_id == $this->user::USER) {
                    $redirectUrl = url('/user/welcome');
                } else {
                    $redirectUrl = null;
                }

                if (!$redirectUrl) {
                    return response()->json(['status' => false, 'message' => 'Role tidak valid.'], 403);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Login berhasil.',
                    'redirect' => $redirectUrl
                ]);
            }

            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Email atau password salah.'], 401);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Terjadi kesalahan. ' . $e->getMessage()], 500);
        }
    }
}
