<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HandymanResource;
use App\Models\Handyman;
use Illuminate\Http\JsonResponse;

class HandymanController extends Controller
{
    /**
     * Get handyman profile
     * 
     * @param Handyman $handyman
     * @return JsonResponse
     */
    public function show(Handyman $handyman): JsonResponse
    {
        $handyman->load(['user', 'services', 'primaryServices']);

        return response()->json([
            'message' => 'Handyman profile retrieved',
            'data' => new HandymanResource($handyman),
        ]);
    }
}