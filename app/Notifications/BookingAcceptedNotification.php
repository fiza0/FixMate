<?php 
namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
        $this->booking->load(['service', 'handyman.user']);
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url('/bookings/' . $this->booking->id);

        return (new MailMessage)
            ->subject('Booking Accepted - ' . $this->booking->booking_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your booking has been accepted!')
            ->line('Handyman: ' . $this->booking->handyman->user->name)
            ->line('Service: ' . $this->booking->service->name)
            ->action('View Booking', $url)
            ->line('The handyman will contact you shortly.');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'handyman_name' => $this->booking->handyman->user->name,
            'message' => 'Your booking has been accepted by ' . $this->booking->handyman->user->name,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'booking_id' => $this->booking->id,
            'message' => 'Booking accepted',
        ]);
    }
}