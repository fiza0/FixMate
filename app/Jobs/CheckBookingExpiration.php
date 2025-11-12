<?php 

namespace App\Jobs;

use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckBookingExpiration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function handle(BookingService $bookingService): void
    {
        // Refresh booking from database
        $this->booking->refresh();

        // If still pending after expiration time, auto-cancel
        if ($this->booking->isPending()) {
            $bookingService->cancelBooking(
                $this->booking,
                $this->booking->user,
                'No handyman accepted within the time limit'
            );
        }
    }
}