<?php 
namespace App\Listeners;

use App\Events\BookingCreated;
use App\Notifications\BookingRequestNotification;

class SendBookingCreatedNotification
{
    public function handle(BookingCreated $event): void
    {
        // Notify the customer
        $event->booking->user->notify(
            new BookingRequestNotification($event->booking)
        );
    }
}