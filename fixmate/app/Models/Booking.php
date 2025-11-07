<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function homeowner() {
    return $this->belongsTo(User::class, 'homeowner_id');
  }
    public function handyman() {
        return $this->belongsTo(User::class, 'handyman_id');
    }
    public function review() {
        return $this->hasOne(Review::class);
    }

}
