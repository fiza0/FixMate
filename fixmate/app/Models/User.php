<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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
        'phone',
        'role',
        'verified'
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
    public function handymanProfile() {
    return $this->hasOne(HandymanProfile::class);
}

    public function bookingsAsHomeowner() {
        return $this->hasMany(Booking::class, 'homeowner_id');
    }

    public function bookingsAsHandyman() {
        return $this->hasMany(Booking::class, 'handyman_id');
    }

    /**
     * Handyman HAS MANY Bookings, and a Booking HAS ONE Review.
     */
    public function reviews(){
        return $this->hasManyThrough(
            Review::class,
            Booking::class,
            'handyman_id', //Foreign key on bookings table
            'booking_id',
            'id',
            'id'
        );
    }

    public function getAverageRatingAttribute(){

        return $this->reviews()->avg('rating');
    }

    /**
     * 
     * ----------HOW TO APPLY avg:------------
     * User variable $handyman, can get average by:
     * $handyman->average_rating and it will be the average   (e.g 4.5).
     */
}
