<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HandymanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'business_name' => $this->business_name,
            'avatar' => $this->avatar ? url('storage/' . $this->avatar) : null,
            'bio' => $this->bio,
            'hourly_rate' => (float) $this->hourly_rate,
            'rating' => (float) $this->rating,
            'total_reviews' => $this->total_reviews,
            'completed_jobs' => $this->completed_jobs,
            'is_available' => $this->is_available,
            'is_verified' => $this->is_verified,
            'response_time_minutes' => $this->response_time_minutes,
            
            'location' => [
                'address' => $this->address,
                'city' => $this->city,
                'state' => $this->state,
                'postal_code' => $this->postal_code,
            ],
            
            'services' => $this->services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'slug' => $service->slug,
                    'is_primary' => $service->pivot->is_primary,
                    'experience_years' => $service->pivot->experience_years,
                ];
            }),
            
            'availability_windows' => $this->availabilityWindows->map(function ($window) {
                return [
                    'day_of_week' => $window->day_of_week,
                    'day_name' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][$window->day_of_week],
                    'start_time' => $window->start_time,
                    'end_time' => $window->end_time,
                ];
            }),
            
            'next_available_slots' => $this->getNextAvailableSlots(5),
            
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}