<?php 
namespace App\Listeners;

use App\Events\BookingStarted;
use App\Events\BookingCompleted;
use App\Events\BookingCancelled;
use App\Notifications\BookingStartedNotification;
use App\Notifications\BookingCompletedNotification;
use App\Notifications\BookingCancelledNotification;

class SendBookingStatusUpdateNotification
{
    public function handle($event): void
    {
        $notification = match (true) {
            $event instanceof BookingStarted => new BookingStartedNotification($event->booking),
            $event instanceof BookingCompleted => new BookingCompletedNotification($event->booking),
            $event instanceof BookingCancelled => new BookingCancelledNotification($event->booking),
            default => null,
        };

        if ($notification) {
            $event->booking->user->notify($notification);
            
            // Also notify handyman if booking is cancelled by customer
            if ($event instanceof BookingCancelled && $event->booking->handyman) {
                $event->booking->handyman->user->notify($notification);
            }
        }
    }
}