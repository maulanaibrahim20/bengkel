<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brandEngine()
    {
        return $this->belongsTo(BrandEngine::class, 'brand_id');
    }
}
