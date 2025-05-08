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

        if ($user->can('super-admin') || Auth::user()->role_id == 1) {
            return view('super-admin.pages.check_booking.index', compact('booking', 'motorcycle', 'motorDetails'));
        }

        if ($user->can('admin') || Auth::user()->role_id == 2) {
            return view('admin.pages.check_booking.index', compact('booking', 'motorcycle', 'motorDetails'));
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

        // Cari booking berdasarkan booking_code
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();

        // Temukan motor terkait dengan booking
        $motorcycle = Motorcycle::where('user_id', $booking->user_id)->first();

        // Update data motor terkait
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

        // Update status booking menjadi 'confirmed' jika sudah diisi semua
        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed and motor details updated.');
    }
}
