<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionTechnician extends Model
{
    protected $guarded = ['id'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function technician()
    {
        return $this->belongsTo(Technician::class, 'technician_id');
    }
}
