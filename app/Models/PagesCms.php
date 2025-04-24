<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PagesCms extends Model
{
    protected $guarded = ['id'];

    public function components()
    {
        return $this->hasMany(ComponentCms::class, 'page_id');
    }
}
