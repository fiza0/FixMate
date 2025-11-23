<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_id',
        'homeowner_id',
        'handyman_id',
        'rating',
        'comment',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }

    public function handyman()
    {
        return $this->belongsTo(User::class, 'handyman_id');
    }
}
