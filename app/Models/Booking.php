<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $guarded = ['id'];

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class);
    }
    public function motorCycleDetail()
    {
        return $this->hasOne(MotorCycleDetails::class, 'booking_id');
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'booking_service');
    }

    public function slot()
    {
        return $this->belongsTo(BookingSlot::class, 'booking_slot_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
