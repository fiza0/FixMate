<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateBookingStatusRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HandymanBookingController extends Controller
{
    public function __construct(
        private BookingService $bookingService
    ) {}

    /**
     * Get all bookings for authenticated handyman
     */
    public function index(Request $request): JsonResponse
    {
        $handyman = $request->user()->handyman;

        if (!$handyman) {
            return response()->json([
                'message' => 'User is not a handyman',
            ], 403);
        }

        $bookings = $handyman->bookings()
            ->with(['service', 'user'])
            ->latest()
            ->paginate(20);

        return response()->json([
            'message' => 'Bookings retrieved',
            'data' => BookingResource::collection($bookings),
            'meta' => [
                'current_page' => $bookings->currentPage(),
                'last_page' => $bookings->lastPage(),
                'per_page' => $bookings->perPage(),
                'total' => $bookings->total(),
            ],
        ]);
    }

    /**
     * Accept a booking
     */
    public function accept(Booking $booking, Request $request): JsonResponse
    {
        $this->authorize('accept', $booking);

        try {
            $booking = $this->bookingService->acceptBooking(
                $booking,
                $request->user()
            );

            return response()->json([
                'message' => 'Booking accepted successfully',
                'data' => new BookingResource($booking),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to accept booking',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Decline a booking
     */
    public function decline(Booking $booking, Request $request): JsonResponse
    {
        $this->authorize('decline', $booking);

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        try {
            $booking = $this->bookingService->declineBooking(
                $booking,
                $request->user(),
                $request->reason
            );

            return response()->json([
                'message' => 'Booking declined successfully',
                'data' => new BookingResource($booking),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to decline booking',
                'error' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Update booking status (en_route, in_progress, completed)
     */
    public function updateStatus(
        UpdateBookingStatusRequest $request,
        Booking $booking
    ): JsonResponse {
        $this->authorize('updateStatus', $booking);

        try {
            $booking = $this->bookingService->updateBookingStatus(
                $booking,
                $request->status,
                $request->user(),
                $request->only(['final_price', 'note'])
            );

            return response()->json([
                'message' => 'Booking status updated successfully',
                'data' => new BookingResource($booking),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update booking status',
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}