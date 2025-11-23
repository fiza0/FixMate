<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandymanProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'skill_category', 'bio', 'min_rate', 'max_rate',
        'average_rating', 'location',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'handyman_id', 'user_id');
    }
}

