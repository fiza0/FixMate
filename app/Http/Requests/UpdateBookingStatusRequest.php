<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => 'required|in:en_route,in_progress,completed',
            'final_price' => 'nullable|numeric|min:0|required_if:status,completed',
            'note' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'final_price.required_if' => 'Final price is required when completing a booking.',
        ];
    }
}
