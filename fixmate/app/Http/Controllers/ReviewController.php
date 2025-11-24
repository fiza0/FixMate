<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Booking $booking)
    {
        $user = Auth::user();

        abort_unless(
            $booking->homeowner_id === $user->id &&
            $booking->status === 'completed',
            403
        );

        // prevent multiple reviews
        if ($booking->review) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'You have already reviewed this booking.');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $user = Auth::user();

        abort_unless(
            $booking->homeowner_id === $user->id &&
            $booking->status === 'completed',
            403
        );

        if ($booking->review) {
            return redirect()->route('bookings.show', $booking)
                ->with('error', 'You have already reviewed this booking.');
        }

        $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $review = Review::create([
            'booking_id'   => $booking->id,
            'homeowner_id' => $user->id,
            'handyman_id'  => $booking->handyman_id,
            'rating'       => $request->rating,
            'comment'      => $request->comment,
        ]);

        // update handyman's average rating
        $handymanProfile = $booking->handyman->handymanProfile;
        if ($handymanProfile) {
            $avg = $booking->handyman->handymanReviews()->avg('rating');
            $handymanProfile->update(['average_rating' => $avg ?? 0]);
        }

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Thank you for your review!');
    }
}
