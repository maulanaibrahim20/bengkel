<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function superAdmin(Request $request)
    {
        return view('super-admin.pages.dashboard.index');
    }
    public function admin(Request $request)
    {
        return view('admin.pages.dashboard.index');
    }
    public function user(Request $request)
    {
        $newRegister = session('new_register', false);
        return view('user.pages.dashboard.index', compact('newRegister'));
    }
}
