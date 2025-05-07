<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingHistoryController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['slot', 'services'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('user.pages.booking_history.index', compact('bookings'));
    }
}
