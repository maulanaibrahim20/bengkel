<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startDate = Carbon::today();
        $endDate = $startDate->copy()->addDays(6);

        $startTime = Carbon::createFromTime(9, 0, 0);
        $endTime = Carbon::createFromTime(19, 30, 0);

        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $time = $startTime->copy();
            while ($time->lte($endTime)) {
                DB::table('booking_slots')->insert([
                    'date' => $date->toDateString(),
                    'time' => $time->format('H:i'),
                    'max_bookings' => 1,
                    'current_bookings' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $time->addMinutes(30);
            }
        }
    }
}
