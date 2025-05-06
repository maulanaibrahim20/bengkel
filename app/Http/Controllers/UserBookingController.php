<?php

namespace App\Http\Controllers;

use App\Models\BookingSlot;
use App\Models\Motorcycle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{

    public function getSlots($date)
    {
        $date = Carbon::parse($date);

        $slots = BookingSlot::whereDate('date', $date)->get();

        $morningSlots = $slots->filter(fn($slot) => Carbon::parse($slot->time)->format('H:i') < '12:00');
        $afternoonSlots = $slots->filter(fn($slot) => Carbon::parse($slot->time)->format('H:i') >= '13:00' && Carbon::parse($slot->time)->format('H:i') <= '18:00');

        return response()->json([
            'morningSlots' => $morningSlots,
            'afternoonSlots' => $afternoonSlots,
        ]);
    }

    public function index()
    {
        $hasMotor = Motorcycle::where('user_id', Auth::user()->id)->exists();

        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addDays(6);

        $bookingSlots = BookingSlot::whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy('date');

        $dates = $bookingSlots->map(function ($slots, $date) {
            return [
                'date' => Carbon::parse($date),
                'slots' => $slots,
            ];
        });

        return view('user.pages.booking.index', [
            'dates' => $dates,
            'startDate' => $startDate,
            'hasMotor' => $hasMotor
        ]);
    }
}
