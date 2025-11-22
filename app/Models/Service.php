<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
    ];

     protected $casts = [
        'is_active' => 'boolean',
    ];

    public function handymen()
    {
        return $this->belongsToMany(Handyman::class, 'handyman_services')
            ->withPivot(['is_primary', 'experience_years'])
            ->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}