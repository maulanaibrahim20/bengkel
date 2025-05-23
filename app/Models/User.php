<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    const SUPER_ADMIN = 1;
    const ADMIN = 2;
    const USER = 3;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'status',
        'profile_image',
        'address',
        'birth_date',
        'gender',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Relasi ke Transaction (seorang user bisa memiliki banyak transaksi)
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Relasi ke Transaction sebagai pembuat transaksi
    public function createdTransactions()
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    // Relasi ke Technician (teknisi)
    public function technicianTransactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_technicians');
    }
}
