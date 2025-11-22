<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AvailabilityWindow extends Model
{
   use HasFactory;

    protected $fillable = [
        'handyman_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function handyman()
    {
        return $this->belongsTo(Handyman::class);
    }}
