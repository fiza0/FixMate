<?php

namespace App\Services;

class ProximityService
{
   /**
     * Geocode an address to lat/lng coordinates
     */
    public function geocodeAddress(string $address): ?array
    {
        // In production, use Google Maps API, OpenCage, or similar
        // For demo purposes, return mock coordinates
        
        // Example with OpenCage (you'd need API key):
        // $response = Http::get('https://api.opencagedata.com/geocode/v1/json', [
        //     'q' => $address,
        //     'key' => config('services.opencage.key'),
        // ]);
        
        // Mock implementation for demo
        return [
            'latitude' => -1.2921 + (rand(-1000, 1000) / 10000),
            'longitude' => 36.8219 + (rand(-1000, 1000) / 10000),
        ];
    }

    /**
     * Calculate distance between two points using Haversine formula
     */
    public function calculateDistance(
        float $lat1,
        float $lon1,
        float $lat2,
        float $lon2
    ): float {
        $earthRadiusKm = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadiusKm * $c;
    }
}
