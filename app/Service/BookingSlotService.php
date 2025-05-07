<?php

namespace App\Service;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookingSlotService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function generateSlotsForDate(string $targetDate): void
    {
        $date = Carbon::parse($targetDate);

        $startTime = Carbon::createFromTime(9, 0, 0);
        $endTime = Carbon::createFromTime(19, 30, 0);

        $time = $startTime->copy();
        while ($time->lte($endTime)) {
            DB::table('booking_slots')->updateOrInsert(
                ['date' => $date->toDateString(), 'time' => $time->format('H:i')],
                [
                    'max_bookings' => 1,
                    'current_bookings' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $time->addMinutes(30);
        }
    }
}
