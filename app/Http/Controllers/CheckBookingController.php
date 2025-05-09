<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Motorcycle;
use App\Models\MotorCycleDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBookingController extends Controller
{
    public function handle(Request $request, $booking_code)
    {
        $user = Auth::user();

        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();
        $motorcycle = Motorcycle::where('user_id', $booking->user_id)->first();
        $motorDetails = MotorCycleDetails::where('booking_id', $booking->id)->first();

        if ($user->role_id == 1 || $user->role_id == 2 || $user->can('super-admin') || $user->can('admin')) {

            if ($booking->status === 'pending') {
                $booking->update(['status' => 'registered']);
            }

            $view = $user->role_id == 1
                ? 'super-admin.pages.check_booking.index'
                : 'admin.pages.check_booking.index';

            return view($view, compact('booking', 'motorcycle', 'motorDetails'));
        }

        abort(403, 'Unauthorized action.');
    }


    public function updateMotorDetails(Request $request, $booking_code)
    {
        $request->validate([
            'year_of_manufacture' => 'required|integer',
            'kilometer_before' => 'required|integer',
            'oil_before' => 'required|string',
            'kilometer_after' => 'required|integer',
            'oil_after' => 'required|string',
        ]);

        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();

        $motorcycle = Motorcycle::where('user_id', $booking->user_id)->first();

        $motorDetails = MotorCycleDetails::updateOrCreate(
            ['booking_id' => $booking->id, 'motorcycle_id' => $motorcycle->id],
            [
                'year_of_manufacture' => $request->year_of_manufacture,
                'kilometer_before' => $request->kilometer_before,
                'oil_before' => $request->oil_before,
                'kilometer_after' => $request->kilometer_after,
                'oil_after' => $request->oil_after,
            ]
        );

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed and motor details updated.');
    }
}
