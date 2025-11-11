<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'handyman_id' => 'required|exists:users,id',
            'service_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
            'estimated_cost' => 'nullable|numeric',
        ]);

        $booking = Booking::create([
            'homeowner_id' => Auth::id(),
            'handyman_id' => $validated['handyman_id'],
            'service_type' => $validated['service_type'],
            'description' => $validated['description'] ?? null,
            'scheduled_at' => $validated['scheduled_at'],
            'status' => 'requested',
            'estimated_cost' => $validated['estimated_cost'] ?? null,
        ]);

        return response()->json($booking, 201);
    }

    public function index()
    {
        $user = Auth::user();
        if($user->role === 'homeowner'){
            $bookings = Booking::where('homeowner_id',$user->id)->with('handyman')->get();
        } else {
            $bookings = Booking::where('handyman_id',$user->id)->with('homeowner')->get();
        }
        return response()->json($bookings);
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $user = Auth::user();

        // only handyman can update status for their jobs; homeowner maybe cancel
        if($user->id !== $booking->handyman_id && $user->id !== $booking->homeowner_id){
            abort(403);
        }

        $request->validate(['status' => 'required|in:accepted,in_progress,completed,cancelled']);

        $booking->status = $request->status;
        $booking->save();

        return response()->json($booking);
    }
}
