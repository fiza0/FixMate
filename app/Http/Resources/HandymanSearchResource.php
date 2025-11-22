<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HandymanSearchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->user->name,
            'business_name' => $this->business_name,
            'avatar' => $this->avatar ? url('storage/' . $this->avatar) : null,
            'bio' => $this->bio,
            'hourly_rate' => (float) $this->hourly_rate,
            'rating' => (float) $this->rating,
            'total_reviews' => $this->total_reviews,
            'completed_jobs' => $this->completed_jobs,
            'is_verified' => $this->is_verified,
            'response_time' => $this->response_time_minutes . ' minutes',
            
            // Distance (from nearby scope)
            'distance' => [
                'km' => isset($this->distance) ? round($this->distance, 2) : null,
                'miles' => isset($this->distance) ? round($this->distance * 0.621371, 2) : null,
            ],
            
            // Primary services
            'primary_services' => $this->primaryServices->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'slug' => $service->slug,
                ];
            }),
            
            // All services
            'all_services' => $this->services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'slug' => $service->slug,
                    'experience_years' => $service->pivot->experience_years,
                ];
            }),
            
            // Next available slots
            'next_available_slots' => $this->getNextAvailableSlots(3),
        ];
    }
}
