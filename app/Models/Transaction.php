<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $guarded = ['id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function technicians()
    {
        return $this->belongsToMany(User::class, 'transaction_technician');
    }

    public function products()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
