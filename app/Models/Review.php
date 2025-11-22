<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable=[
        'booking_id',
        'reviewer_id',
        'rating',
        'comment',

    ];
    public function booking() {
    return $this->belongsTo(Booking::class);
}
    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

}
