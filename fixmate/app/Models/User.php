<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'role', 'profile_photo', 'verified',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'verified' => 'boolean',
    ];

    public function handymanProfile()
    {
        return $this->hasOne(HandymanProfile::class);
    }

    public function homeownerBookings()
    {
        return $this->hasMany(Booking::class, 'homeowner_id');
    }

    public function handymanBookings()
    {
        return $this->hasMany(Booking::class, 'handyman_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isHandyman(): bool
    {
        return $this->role === 'handyman';
    }

    public function isHomeowner(): bool
    {
        return $this->role === 'homeowner';
    }
}

