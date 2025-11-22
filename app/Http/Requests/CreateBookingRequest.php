<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'booking_type' => 'required|in:now,scheduled',
            'handyman_id' => 'nullable|exists:handymen,id|required_if:booking_type,scheduled',
            
            // Customer details (optional, will default to auth user)
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            
            // Service location
            'service_address' => 'required|string|max:500',
            'service_city' => 'required|string|max:100',
            'service_state' => 'nullable|string|max:100',
            'service_postal_code' => 'nullable|string|max:20',
            'service_latitude' => 'nullable|numeric|between:-90,90',
            'service_longitude' => 'nullable|numeric|between:-180,180',
            
            // Scheduling (required for scheduled bookings)
            'scheduled_start' => 'required_if:booking_type,scheduled|nullable|date|after:now',
            'scheduled_end' => 'nullable|date|after:scheduled_start',
            
            // Service details
            'description' => 'required|string|max:2000',
            'special_instructions' => 'nullable|string|max:1000',
            'estimated_hours' => 'nullable|numeric|min:0.5|max:24',
        ];
    }

    public function messages(): array
    {
        return [
            'handyman_id.required_if' => 'Please select a handyman for scheduled bookings.',
            'scheduled_start.required_if' => 'Please provide a start time for scheduled bookings.',
            'scheduled_start.after' => 'Scheduled start time must be in the future.',
        ];
    }
}
