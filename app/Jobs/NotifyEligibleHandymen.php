<?php 
namespace App\Jobs;

use App\Models\Booking;
use App\Models\Handyman;
use App\Notifications\BookingRequestNotification;
use App\Services\HandymanMatchingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyEligibleHandymen implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Booking $booking)
    {
    }

    public function handle(HandymanMatchingService $matchingService): void
    {
        // Find top N eligible handymen
        $handymen = $matchingService->getTopHandymenForBookNow(
            $this->booking->service_id,
            $this->booking->service_latitude,
            $this->booking->service_longitude
        );

        // Notify each handyman
        foreach ($handymen as $handyman) {
            /** @var Handyman $handyman */
            $handyman->user->notify(
                new BookingRequestNotification($this->booking)
            );
        }

        // Schedule a job to check if booking was accepted after expiration time
        dispatch(new CheckBookingExpiration($this->booking))
            ->delay(now()->addMinutes(config('handyman.booking_expiration_minutes', 30)));
    }
}