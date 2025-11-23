<?php 
namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class BookingRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
        $this->booking->load(['service', 'user']);
    }

    public function via($notifiable): array
    {
        $channels = ['database', 'broadcast'];
        
        if (config('handyman.notification_channels.email')) {
            $channels[] = 'mail';
        }
        
        // Add SMS channel if enabled
        // if (config('handyman.notification_channels.sms')) {
        //     $channels[] = 'nexmo'; // or 'twilio'
        // }
        
        return $channels;
    }

    public function toMail($notifiable): MailMessage
    {
        $url = url('/bookings/' . $this->booking->id);

        return (new MailMessage)
            ->subject('New Booking Request - ' . $this->booking->service->name)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have a new booking request.')
            ->line('Service: ' . $this->booking->service->name)
            ->line('Location: ' . $this->booking->service_city)
            ->line('Description: ' . $this->booking->description)
            ->action('View Booking', $url)
            ->line('Please respond as soon as possible!');
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'service' => $this->booking->service->name,
            'customer_name' => $this->booking->customer_name,
            'location' => $this->booking->service_city,
            'message' => 'New booking request for ' . $this->booking->service->name,
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'booking_id' => $this->booking->id,
            'booking_number' => $this->booking->booking_number,
            'service' => $this->booking->service->name,
            'message' => 'New booking request',
        ]);
    }
}