<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserBookingController extends Controller
{
    public function index()
    {
        return view('user.pages.booking.index');
    }
}
