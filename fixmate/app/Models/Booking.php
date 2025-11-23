<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'homeowner_id', 'handyman_id', 'service_type', 'description',
        'scheduled_at', 'status', 'estimated_cost', 'final_cost',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function homeowner()
    {
        return $this->belongsTo(User::class, 'homeowner_id');
    }

    public function handyman()
    {
        return $this->belongsTo(User::class, 'handyman_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}

