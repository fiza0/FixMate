<?php

namespace App\Services;

use App\Models\Handyman;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class HandymanMatchingService
{
    public function __construct(
        private ProximityService $proximityService
    ) {}

    /**
     * Find eligible handymen for a booking
     */
    public function findEligibleHandymen(
        int $serviceId,
        float $latitude,
        float $longitude,
        array $filters = []
    ): Collection {
        $maxDistance = $filters['max_distance'] ?? config('handyman.max_search_distance');
        
        $query = Handyman::query()
            ->available()
            ->offeringService($serviceId)
            ->nearby($latitude, $longitude, $maxDistance);

        // Apply filters
        if (isset($filters['min_rating'])) {
            $query->where('rating', '>=', $filters['min_rating']);
        }

        if (isset($filters['max_hourly_rate'])) {
            $query->where('hourly_rate', '<=', $filters['max_hourly_rate']);
        }

        if (isset($filters['min_hourly_rate'])) {
            $query->where('hourly_rate', '>=', $filters['min_hourly_rate']);
        }

        if (isset($filters['is_verified'])) {
            $query->where('is_verified', $filters['is_verified']);
        }

        // Sorting
        $sortBy = $filters['sort_by'] ?? 'distance';
        $sortOrder = $filters['sort_order'] ?? 'asc';

        switch ($sortBy) {
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'price':
                $query->orderBy('hourly_rate', $sortOrder);
                break;
            case 'reviews':
                $query->orderBy('total_reviews', $sortOrder);
                break;
            case 'distance':
            default:
                // Already ordered by distance in nearby scope
                break;
        }

        return $query->get();
    }

    /**
     * Get top N handymen for "Book Now" notifications
     */
    public function getTopHandymenForBookNow(
        int $serviceId,
        float $latitude,
        float $longitude,
        int $count = null
    ): Collection {
        $count = $count ?? config('handyman.book_now_notify_count', 5);
        
        return $this->findEligibleHandymen($serviceId, $latitude, $longitude)
            ->take($count);
    }
}
