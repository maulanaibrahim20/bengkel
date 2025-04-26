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
            return back()->with('error', $validate->errors()->first());
        };

        try {

            $user = $this->user->where('email', $request->email)->first();
            if (!$user) {
                DB::rollBack();
                return back()->with('error', 'Invalid email or password. 1');
            }
            if (!Hash::check($request->password, $user->password)) {
                DB::rollBack();
                return back()->with('error', 'Invalid email or password. 2');
            }

            if (Auth::attempt(["email" => $request->email, "password" => $request->password])) {

                $request->session()->regenerate();

                if ($user->role_id == $this->user::SUPER_ADMIN) {
                    DB::commit();
                    return redirect('/super-admin/dashboard')->with('success', 'Login successful.');
                } elseif ($user->role_id == $this->user::ADMIN) {
                    DB::commit();
                    return redirect('/admin/dashboard')->with('success', 'Login successful.');
                } elseif ($user->role_id == $this->user::USER) {
                    DB::commit();
                    return redirect('user/dashboard')->with('success', 'Login successful.');
                } else {
                    DB::rollBack();
                    return back()->with('error', 'Invalid role.');
                }
            }
            DB::rollBack();
            return back()->with('error', 'Invalid email or password.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.' . $e->getMessage());
        }
    }
}
