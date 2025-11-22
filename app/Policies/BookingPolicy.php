<?php
namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine if user can create bookings
     */
    public function create(User $user): bool
    {
        return $user->isCustomer() || $user->isHandyman();
    }

    /**
     * Determine if user can view the booking
     */
    public function view(User $user, Booking $booking): bool
    {
        // Customer who created the booking
        if ($user->id === $booking->user_id) {
            return true;
        }

        // Handyman assigned to the booking
        if ($user->handyman && $user->handyman->id === $booking->handyman_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine if user can cancel the booking
     */
    public function cancel(User $user, Booking $booking): bool
    {
        // Only the customer who created the booking can cancel it
        if ($user->id !== $booking->user_id) {
            return false;
        }

        return $booking->canBeCancelled();
    }

    /**
     * Determine if handyman can accept the booking
     */
    public function accept(User $user, Booking $booking): bool
    {
        if (!$user->isHandyman()) {
            return false;
        }

        return $booking->canBeAccepted();
    }

    /**
     * Determine if handyman can decline the booking
     */
    public function decline(User $user, Booking $booking): bool
    {
        if (!$user->isHandyman()) {
            return false;
        }

        return $booking->canBeDeclined();
    }

    /**
     * Determine if handyman can update booking status
     */
    public function updateStatus(User $user, Booking $booking): bool
    {
        if (!$user->isHandyman()) {
            return false;
        }

        // Only the assigned handyman can update status
        if ($user->handyman->id !== $booking->handyman_id) {
            return false;
        }

        // Can only update if booking is accepted or in progress
        return in_array($booking->status, ['accepted', 'en_route', 'in_progress']);
    }
}