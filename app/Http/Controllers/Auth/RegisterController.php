<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    protected $user;

    public function index(Request $request)
    {
        return view('auth.register.index');
    }

    public function register(Request $request) {}
}
