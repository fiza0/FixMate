<?php 
namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Notification;

class BookingDeclinedNotification extends Notification
{
    public function __construct(public Booking $booking) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'A handyman declined your booking request',
        ];
    }
}
