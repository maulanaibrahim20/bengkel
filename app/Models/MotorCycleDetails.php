<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotorCycleDetails extends Model
{
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function motorcycle()
    {
        return $this->belongsTo(Motorcycle::class);
    }
}
