<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public function booking() {
    return $this->belongsTo(Booking::class);
}
    public function reviewer() {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

}
