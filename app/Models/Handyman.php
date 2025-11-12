<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Handyman extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'bio',
        'avatar',
        'hourly_rate',
        'latitude',
        'longitude',
        'address',
        'rating',
        'total_reviews',
        'completed_jobs',
        'is_available',
        'is_verified',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'rating' => 'decimal:2',
        'is_available' => 'boolean',
        'is_verified' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'handyman_services')
            ->withPivot(['is_primary', 'experience_years'])
            ->withTimestamps();
    }

    public function primaryServices()
    {
        return $this->services()->wherePivot('is_primary', true);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availabilityWindows()
    {
        return $this->hasMany(AvailabilityWindow::class);
    }

    /**
     * Scope for proximity search using Haversine formula
     */
    public function scopeNearby(Builder $query, float $latitude, float $longitude, float $radiusKm = 50)
    {
        $earthRadiusKm = 6371;

        return $query->selectRaw("
                *,
                (
                    {$earthRadiusKm} * acos(
                        cos(radians(?)) * 
                        cos(radians(latitude)) * 
                        cos(radians(longitude) - radians(?)) + 
                        sin(radians(?)) * 
                        sin(radians(latitude))
                    )
                ) AS distance
            ", [$latitude, $longitude, $latitude])
            ->having('distance', '<=', $radiusKm)
            ->orderBy('distance');
    }

    /**
     * Scope for available handymen
     */
    public function scopeAvailable(Builder $query)
    {
        return $query->where('is_available', true);
    }

    /**
     * Scope for handymen offering a specific service
     */
    public function scopeOfferingService(Builder $query, int $serviceId)
    {
        return $query->whereHas('services', function ($q) use ($serviceId) {
            $q->where('service_id', $serviceId);
        });
    }

    /**
     * Get next available time slots
     */
    public function getNextAvailableSlots(int $count = 3)
    {
        $slots = [];
        $currentDate = now();

        for ($i = 0; $i < 14; $i++) { // Check next 2 weeks
            $date = $currentDate->copy()->addDays($i);
            $dayOfWeek = $date->dayOfWeek;

            $windows = $this->availabilityWindows()
                ->where('day_of_week', $dayOfWeek)
                ->where('is_active', true)
                ->get();

            foreach ($windows as $window) {
                $startDateTime = $date->copy()->setTimeFromTimeString($window->start_time);
                $endDateTime = $date->copy()->setTimeFromTimeString($window->end_time);

                if ($startDateTime->isFuture()) {
                    $slots[] = [
                        'start' => $startDateTime,
                        'end' => $endDateTime,
                    ];

                    if (count($slots) >= $count) {
                        return $slots;
                    }
                }
            }
        }

        return $slots;
    }
}
