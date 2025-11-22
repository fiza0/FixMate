<?php 
namespace App\Listeners;

use App\Events\BookingAccepted;
use App\Models\Handyman;
use App\Notifications\BookingRequestNotification;
use Illuminate\Support\Facades\Notification;

class NotifyOtherHandymenBookingFilled
{
    public function handle(BookingAccepted $event): void
    {
        // For "Book Now" requests, notify other handymen that the booking is filled
        if ($event->booking->booking_type === 'now') {
            // This would typically query pending notifications
            // and cancel them or send a "booking filled" message
        }
    }
}