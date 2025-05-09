<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    protected $guarded = ['id'];

    protected $table = 'booking_service';

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
