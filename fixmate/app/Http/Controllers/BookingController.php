<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isHandyman()) {
            $bookings = Booking::where('handyman_id', $user->id)->latest()->get();
        } else {
            $bookings = Booking::where('homeowner_id', $user->id)->latest()->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    public function create(User $handyman)
    {
        abort_unless($handyman->isHandyman(), 404);

        return view('bookings.create', compact('handyman'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
<<<<<<< HEAD
            'handyman_id'  => ['required', 'exists:users,id'],
            'service_type' => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'scheduled_at' => ['required', 'date', 'after:now'],
=======
            'handyman_id'    => ['required', 'exists:users,id'],
            'service_type'   => ['required', 'string', 'max:255'],
            'description'    => ['required', 'string'],
            'scheduled_at'   => ['required', 'date', 'after:now'],
>>>>>>> final-merge-2
            'estimated_cost' => ['nullable', 'numeric', 'min:0'],
        ]);

        $handymanId  = $request->handyman_id;
        $scheduledAt = $request->scheduled_at;

<<<<<<< HEAD
        // prevent double-booking that handyman at that datetime
=======
        // prevent double‑booking
>>>>>>> final-merge-2
        $conflict = Booking::where('handyman_id', $handymanId)
            ->where('scheduled_at', $scheduledAt)
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->exists();

        if ($conflict) {
            return back()
                ->withErrors(['scheduled_at' => 'This handyman is already booked at that time.'])
                ->withInput();
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

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking request created.');
    }

    public function show(Booking $booking)
    {
        $this->authorizeView($booking);

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorizeChange($booking);

        if (! in_array($booking->status, ['requested', 'accepted', 'in_progress'])) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled.');
    }

    public function accept(Booking $booking): RedirectResponse
    {
        $this->authorizeHandyman($booking);

        if ($booking->status !== 'requested') {
            return back()->with('error', 'Only requested bookings can be accepted.');
        }

        $booking->update(['status' => 'accepted']);

        return back()->with('success', 'Booking accepted.');
    }

    public function start(Booking $booking): RedirectResponse
    {
        $this->authorizeHandyman($booking);

        if ($booking->status !== 'accepted') {
            return back()->with('error', 'Only accepted bookings can be started.');
        }

        $booking->update(['status' => 'in_progress']);

        return back()->with('success', 'Booking started.');
    }

    public function complete(Booking $booking): RedirectResponse
    {
        $this->authorizeHandyman($booking);

        if ($booking->status !== 'in_progress') {
            return back()->with('error', 'Only in-progress bookings can be completed.');
        }

        $booking->update(['status' => 'completed']);

        return back()->with('success', 'Booking completed.');
    }

    protected function authorizeView(Booking $booking): void
    {
        $user = Auth::user();

        if (
            $user->id !== $booking->homeowner_id &&
            $user->id !== $booking->handyman_id &&
            ! $user->isAdmin()
        ) {
            abort(403);
        }
    }

    protected function authorizeChange(Booking $booking): void
    {
        $user = Auth::user();

        if ($user->id !== $booking->homeowner_id && ! $user->isAdmin()) {
            abort(403);
        }
    }

    protected function authorizeHandyman(Booking $booking): void
    {
        $user = Auth::user();

        if ($user->id !== $booking->handyman_id && ! $user->isAdmin()) {
            abort(403);
        }
    }
}
