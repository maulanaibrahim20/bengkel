<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = ['id'];

    public function detail()
    {
        return $this->hasMany(ServiceDetail::class, 'service_id');
    }
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_service');
    }
}
