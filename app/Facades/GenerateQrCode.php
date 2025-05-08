<?php

namespace App\Facades;

use SimpleSoftwareIO\QrCode\Facades\QrCode;

class GenerateQrCode
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function generateBookingQrCode($booking_code)
    {
        $qrContent = url('check-booking/' . $booking_code);

        $qrCode = QrCode::format('png')
            ->merge(public_path('img/logo.png'), 0.3, true)
            ->size(300)
            ->errorCorrection('H')
            ->generate($qrContent);

        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrCode);

        return $qrBase64;
    }
}
