<?php 
namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Notification;

class BookingCancelledNotification extends Notification
{
    public function __construct(public Booking $booking) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'reason' => $this->booking->cancellation_reason,
            'message' => 'Booking cancelled',
        ];
    }
}