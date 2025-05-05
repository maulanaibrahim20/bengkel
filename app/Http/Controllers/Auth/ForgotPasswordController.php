<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }
    public function index()
    {
        return view('auth.forgot_password.index');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        DB::beginTransaction();

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            DB::commit();

            if ($status === Password::RESET_LINK_SENT) {
                DB::commit();

                if ($request->ajax()) {
                    return response()->json(['message' => __($status)]);
                }

                return back()->with('success', __($status));
            }

            DB::rollBack();

            if ($request->ajax()) {
                return response()->json(['message' => __($status)], 400);
            }

            return back()->with('error', __($status));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan. Coba lagi.' . $e->getMessage());
        }
    }
}
