<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isHandyman()) {
            $bookings = Booking::where('handyman_id', $user->id)->latest()->get();
        } else {
            $bookings = Booking::where('homeowner_id', $user->id)->latest()->get();
        }

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $request->validate([
            'handyman_id'    => ['required', 'exists:users,id'],
            'service_type'   => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'scheduled_at'   => ['required', 'date', 'after:now'],
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        $handymanId  = $request->handyman_id;
        $scheduledAt = $request->scheduled_at;

        $conflict = Booking::where('handyman_id', $handymanId)
            ->where('scheduled_at', $scheduledAt)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'This handyman is already booked at that time.',
            ], 422);
        }

        $booking = Booking::create([
            'homeowner_id'   => Auth::id(),
            'handyman_id'    => $handymanId,
            'service_type'   => $request->service_type,
            'description'    => $request->description,
            'scheduled_at'   => $scheduledAt,
            'status'         => 'requested',
            'estimated_cost' => $request->estimated_cost,
        ]);

        return response()->json($booking, 201);
    }
}
