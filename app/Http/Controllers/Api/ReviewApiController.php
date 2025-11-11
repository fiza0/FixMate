<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Booking;

class ReviewApiController extends Controller
{
    public function __construct(){ $this->middleware('auth:sanctum'); }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        if($booking->status !== 'completed' || $booking->homeowner_id !== Auth::id()){
            abort(403, 'Cannot review this booking.');
        }

        $review = Review::create([
            'booking_id' => $booking->id,
            'reviewer_id' => Auth::id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        // Recalculate average rating
        $handymanId = $booking->handyman_id;
        $avg = Review::whereHas('booking', fn($q)=> $q->where('handyman_id',$handymanId))->avg('rating') ?? 0;
        $profile = $booking->handyman->handymanProfile;
        if($profile){
            $profile->average_rating = round($avg,2);
            $profile->save();
        }

        return response()->json($review,201);
    }
}
