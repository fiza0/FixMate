<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchHandymenRequest;
use App\Http\Resources\HandymanSearchResource;
use App\Models\Service;
use App\Services\HandymanMatchingService;
use Illuminate\Http\JsonResponse;

class ServiceSearchController extends Controller
{
    public function __construct(
        private HandymanMatchingService $matchingService
    ) {}

    /**
     * Search for handymen by service
     * 
     * @param SearchHandymenRequest $request
     * @return JsonResponse
     */
    public function search(SearchHandymenRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Find service by name or slug
        $service = Service::where('slug', $validated['service'])
            ->orWhere('name', 'LIKE', '%' . $validated['service'] . '%')
            ->where('is_active', true)
            ->first();

        if (!$service) {
            return response()->json([
                'message' => 'Service not found',
                'data' => [],
            ], 404);
        }

        // Find eligible handymen
        $handymen = $this->matchingService->findEligibleHandymen(
            $service->id,
            $validated['latitude'],
            $validated['longitude'],
            [
                'max_distance' => $validated['max_distance'] ?? null,
                'min_rating' => $validated['min_rating'] ?? null,
                'max_hourly_rate' => $validated['max_hourly_rate'] ?? null,
                'min_hourly_rate' => $validated['min_hourly_rate'] ?? null,
                'is_verified' => $validated['is_verified'] ?? null,
                'sort_by' => $validated['sort_by'] ?? 'distance',
                'sort_order' => $validated['sort_order'] ?? 'asc',
            ]
        );

        return response()->json([
            'message' => 'Handymen found',
            'data' => [
                'service' => [
                    'id' => $service->id,
                    'name' => $service->name,
                    'slug' => $service->slug,
                ],
                'handymen' => HandymanSearchResource::collection($handymen),
                'count' => $handymen->count(),
            ],
        ]);
    }
}