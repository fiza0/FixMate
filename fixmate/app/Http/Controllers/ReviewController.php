<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Booking $booking)
    {
        //
        $request->validate([
            'rating'=>'required|integer|min:1|max:5',
            'comment'=>'nullable|string',
        ]);

        //Authorization: Only homeowner of this booking can review
        if($booking->homeowner_id!==Auth::id()){
            return back()->with('error','You are not authorized to review this booking.');
        }

        //Booking status: Must be 'completed'
        if($booking->status !== 'completed'){
            return back()->with('error', 'You can only review after completed bookings.');
        }

        //(One review per booking) Check for existing reviews:
        $existingReview = Review::where('booking_id',$booking->id)->exists();
        if($existingReview){
            return back()->with('error','You have already reviewed this booking.');
        }


        //Create review:
        Review::create([
            'booking_id' => $booking->id,
            'reviewer_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success','Thank you for your review!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}