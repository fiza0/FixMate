<?php 
namespace App\Listeners;

use App\Events\BookingAccepted;
use App\Notifications\BookingAcceptedNotification;

class SendBookingAcceptedNotification
{
    public function handle(BookingAccepted $event): void
    {
        // Notify the customer
        $event->booking->user->notify(
            new BookingAcceptedNotification($event->booking)
        );
    }
}