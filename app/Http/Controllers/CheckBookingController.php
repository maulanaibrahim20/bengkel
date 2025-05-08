<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBookingController extends Controller
{
    public function handle(Request $request, $booking_code)
    {
        $user = Auth::user();

        if ($user->can('super-admin') || Auth::user()->role_id == 1) {
            return view('super-admin.pages.check_booking.index');
        }

        if ($user->can('admin') || Auth::user()->role_id == 2) {
            return view('admin.pages.check_booking.index');
        }

        abort(403, 'Unauthorized action.');
    }
}
