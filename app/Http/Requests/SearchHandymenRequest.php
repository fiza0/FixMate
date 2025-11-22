<?php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchHandymenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'max_distance' => 'nullable|numeric|min:1|max:200',
            'min_rating' => 'nullable|numeric|between:0,5',
            'max_hourly_rate' => 'nullable|numeric|min:0',
            'min_hourly_rate' => 'nullable|numeric|min:0',
            'is_verified' => 'nullable|boolean',
            'sort_by' => 'nullable|in:distance,rating,price,reviews',
            'sort_order' => 'nullable|in:asc,desc',
        ];
    }
}
