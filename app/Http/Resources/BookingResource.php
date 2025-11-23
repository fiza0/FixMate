<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'booking_number' => $this->booking_number,
            'booking_type' => $this->booking_type,
            'status' => $this->status,
            
            'customer' => [
                'name' => $this->customer_name,
                'phone' => $this->customer_phone,
                'email' => $this->customer_email,
            ],
            
            'service' => [
                'id' => $this->service->id,
                'name' => $this->service->name,
                'slug' => $this->service->slug,
            ],
            
            'handyman' => $this->handyman ? [
                'id' => $this->handyman->id,
                'name' => $this->handyman->user->name,
                'business_name' => $this->handyman->business_name,
                'avatar' => $this->handyman->avatar ? url('storage/' . $this->handyman->avatar) : null,
                'phone' => $this->handyman->user->phone,
                'rating' => (float) $this->handyman->rating,
            ] : null,
            
            'location' => [
                'address' => $this->service_address,
                'city' => $this->service_city,
                'state' => $this->service_state,
                'postal_code' => $this->service_postal_code,
            ],
            
            'schedule' => [
                'scheduled_start' => $this->scheduled_start?->toISOString(),
                'scheduled_end' => $this->scheduled_end?->toISOString(),
                'actual_start' => $this->actual_start?->toISOString(),
                'actual_end' => $this->actual_end?->toISOString(),
            ],
            
            'details' => [
                'description' => $this->description,
                'special_instructions' => $this->special_instructions,
                'estimated_hours' => $this->estimated_hours ? (float) $this->estimated_hours : null,
            ],
            
            'pricing' => [
                'quoted_price' => $this->quoted_price ? (float) $this->quoted_price : null,
                'final_price' => $this->final_price ? (float) $this->final_price : null,
                'payment_status' => $this->payment_status,
            ],
            
            'timestamps' => [
                'created_at' => $this->created_at->toISOString(),
                'accepted_at' => $this->accepted_at?->toISOString(),
                'declined_at' => $this->declined_at?->toISOString(),
                'cancelled_at' => $this->cancelled_at?->toISOString(),
                'completed_at' => $this->completed_at?->toISOString(),
            ],
            
            'cancellation_reason' => $this->cancellation_reason,
            
            'status_history' => $this->when(
                $this->relationLoaded('statusHistories'),
                fn() => $this->statusHistories->map(function ($history) {
                    return [
                        'status' => $history->status,
                        'note' => $history->note,
                        'changed_at' => $history->created_at->toISOString(),
                    ];
                })
            ),
        ];
    }
}