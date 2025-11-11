<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'handyman_id' => 'required|exists:users,id',
        'service_type' => 'required|string|max:255',
        'description' => 'nullable|string',
        'scheduled_at' => 'required|date|after:now',
        'estimated_cost' => 'nullable|numeric',
    ];
}

}
