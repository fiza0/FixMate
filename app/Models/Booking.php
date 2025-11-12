<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
  use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'handyman_id',
        'service_id',
        'booking_type',
        'status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'service_address',
        'service_latitude',
        'service_longitude',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'description',
        'special_instructions',
        'estimated_hours',
        'quoted_price',
        'final_price',
        'payment_status',
        'payment_method',
        'payment_transaction_id',
        'accepted_at',
        'declined_at',
        'cancelled_at',
        'completed_at',
        'cancellation_reason',
    ];

    protected $casts = [
        'service_latitude' => 'decimal:7',
        'service_longitude' => 'decimal:7',
        'estimated_hours' => 'decimal:2',
        'quoted_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            $booking->booking_number = 'BK' . strtoupper(uniqid());
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function handyman()
    {
        return $this->belongsTo(Handyman::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(BookingStatusHistory::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function canBeAccepted(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeDeclined(): bool
    {
        return $this->status === 'pending';
    }

    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'accepted', 'en_route']);
    }

}
