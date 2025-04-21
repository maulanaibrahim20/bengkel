<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function login(Request $request) {}
}
