<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSlot;
use App\Models\Motorcycle;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserBookingController extends Controller
{
    public function getSlots($date)
    {
        $date = Carbon::parse($date);

        $slots = BookingSlot::whereDate('date', $date)->get();

        $morningSlots = $slots->filter(fn($slot) => Carbon::parse($slot->time)->format('H:i') < '12:00')->values();
        $afternoonSlots = $slots->filter(fn($slot) => Carbon::parse($slot->time)->format('H:i') >= '13:00' && Carbon::parse($slot->time)->format('H:i') <= '18:00')->values();

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

    public function create(Request $request)
    {
        $slot = BookingSlot::findOrFail($request->slot_id);
        $services = Service::with('detail')->get(); // dengan detail servicenya

        return view('user.pages.booking.choose-service', compact('slot', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_id' => 'required|exists:booking_slots,id',
            'service_ids' => 'required|array',
            'service_ids.*' => 'exists:services,id',
            'complaint' => 'nullable|string|max:1000',
        ]);

        DB::beginTransaction();

        try {
            $slot = BookingSlot::findOrFail($request->slot_id);

            if ($slot->current_bookings >= $slot->max_bookings) {
                return redirect()->back()->with('error', 'Slot sudah penuh.');
            }

            $existingBooking = Booking::where('user_id', Auth::id())
                ->whereHas('slot', function ($query) use ($slot) {
                    $query->whereDate('date', $slot->date);
                })
                ->exists();

            if ($existingBooking) {
                DB::rollBack();
                return redirect('/user/booking')->with('warning', 'Kamu sudah memiliki booking pada tanggal ini.');
            }

            $service = Service::find($request->service_ids[0]);
            $serviceInitial = strtoupper(substr($service->name, 0, 2));

            $totalBooking = Booking::count() + 100 + 1;

            $code = sprintf('DANIEL-FR-%s-%03d', $serviceInitial, $totalBooking);

            $booking = Booking::create([
                'booking_code' => $code,
                'user_id' => Auth::id(),
                'booking_slot_id' => $slot->id,
                'status' => 'pending',
                'complaint' => $request->complaint,
            ]);

            $booking->services()->attach($request->service_ids);

            $slot->increment('current_bookings');

            DB::commit();

            return redirect('/user/booking')->with('success', 'Booking berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat booking: ' . $e->getMessage());
        }
    }
}
