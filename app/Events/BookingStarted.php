<?php 
namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingStarted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Booking $booking)
    {
        $this->booking->load(['service', 'handyman.user']);
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->booking->user_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'booking.started';
    }
}