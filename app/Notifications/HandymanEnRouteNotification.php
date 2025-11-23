<?php 
namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class HandymanEnRouteNotification extends Notification
{
    public function __construct(public Booking $booking)
    {
        $this->booking->load(['handyman.user']);
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Handyman En Route - ' . $this->booking->booking_number)
            ->line($this->booking->handyman->user->name . ' is on the way!')
            ->line('They should arrive shortly.');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'message' => 'Handyman is en route',
        ];
    }
}