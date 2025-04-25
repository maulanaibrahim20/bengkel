<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const USER = 3;

    protected $guarded = ['id'];
    protected $table = 'roles';
}
