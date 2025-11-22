<?php 
namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingCancelled implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->load(['service', 'handyman.user']);
    }

    public function broadcastOn(): array
    {
        $channels = [
            new PrivateChannel('user.' . $this->booking->user_id),
        ];

        if ($this->booking->handyman_id) {
            $channels[] = new PrivateChannel('handyman.' . $this->booking->handyman_id);
        }

        return $channels;
    }

    public function broadcastAs(): string
    {
        return 'booking.cancelled';
    }
}