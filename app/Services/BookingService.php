<?php


namespace App\Services;

use App\Events\BookingAccepted;
use App\Events\BookingCancelled;
use App\Events\BookingCompleted;
use App\Events\BookingCreated;
use App\Events\BookingDeclined;
use App\Events\BookingStarted;
use App\Jobs\NotifyEligibleHandymen;
use App\Models\Booking;
use App\Models\BookingStatusHistory;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function __construct(
        private HandymanMatchingService $matchingService,
        private ProximityService $proximityService
    ) {}

    /**
     * Create a new booking
     */
    public function createBooking(array $data, User $user): Booking
    {
        return DB::transaction(function () use ($data, $user) {
            // Geocode service address if coordinates not provided
            if (!isset($data['service_latitude']) || !isset($data['service_longitude'])) {
                $fullAddress = sprintf(
                    '%s',
                    $data['service_address'],
                );
                
                $coordinates = $this->proximityService->geocodeAddress($fullAddress);
                $data['service_latitude'] = $coordinates['latitude'];
                $data['service_longitude'] = $coordinates['longitude'];
            }

            // Create booking
            $booking = Booking::create([
                'user_id' => $user->id,
                'service_id' => $data['service_id'],
                'booking_type' => $data['booking_type'],
                'customer_name' => $data['customer_name'] ?? $user->name,
                'customer_phone' => $data['customer_phone'] ?? $user->phone,
                'customer_email' => $data['customer_email'] ?? $user->email,
                'service_address' => $data['service_address'],
                'service_latitude' => $data['service_latitude'],
                'service_longitude' => $data['service_longitude'],
                'description' => $data['description'],
                'special_instructions' => $data['special_instructions'] ?? null,
                'estimated_hours' => $data['estimated_hours'] ?? null,
                'scheduled_start' => $data['scheduled_start'] ?? null,
                'scheduled_end' => $data['scheduled_end'] ?? null,
                'status' => 'pending',
            ]);

            // Add status history
            $this->addStatusHistory($booking, 'pending', 'Booking created', $user->id);

            // Fire event
            event(new BookingCreated($booking));

            // For "Book Now", dispatch job to notify handymen
            if ($booking->booking_type === 'now') {
                NotifyEligibleHandymen::dispatch($booking);
            } elseif ($booking->booking_type === 'scheduled' && isset($data['handyman_id'])) {
                // For scheduled bookings with specific handyman
                $booking->update(['handyman_id' => $data['handyman_id']]);
            }

            return $booking->fresh(['service', 'handyman']);
        });
    }

    /**
     * Handyman accepts a booking
     */
    public function acceptBooking(Booking $booking, User $handyman): Booking
    {
        return DB::transaction(function () use ($booking, $handyman) {
            if (!$booking->canBeAccepted()) {
                throw new \Exception('Booking cannot be accepted in its current state.');
            }

            $booking->update([
                'handyman_id' => $handyman->handyman->id,
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            $this->addStatusHistory($booking, 'accepted', 'Booking accepted by handyman', $handyman->id);

            event(new BookingAccepted($booking));

            return $booking->fresh(['service', 'handyman']);
        });
    }

    /**
     * Handyman declines a booking
     */
    public function declineBooking(Booking $booking, User $handyman, ?string $reason = null): Booking
    {
        return DB::transaction(function () use ($booking, $handyman, $reason) {
            if (!$booking->canBeDeclined()) {
                throw new \Exception('Booking cannot be declined in its current state.');
            }

            // For "Book Now" requests, we don't change status to declined
            // We just log that this handyman declined and continue notifying others
            $this->addStatusHistory(
                $booking,
                'declined_by_' . $handyman->id,
                $reason ?? 'Handyman declined',
                $handyman->id
            );

            event(new BookingDeclined($booking, $handyman));

            return $booking->fresh(['service', 'handyman']);
        });
    }

    /**
     * Update booking status (en_route, in_progress, completed)
     */
    public function updateBookingStatus(
        Booking $booking,
        string $status,
        User $user,
        ?array $additionalData = []
    ): Booking {
        return DB::transaction(function () use ($booking, $status, $user, $additionalData) {
            $updateData = ['status' => $status];

            switch ($status) {
                case 'en_route':
                    // Handyman is on the way
                    break;
                case 'in_progress':
                    $updateData['actual_start'] = now();
                    event(new BookingStarted($booking));
                    break;
                case 'completed':
                    $updateData['actual_end'] = now();
                    $updateData['completed_at'] = now();
                    if (isset($additionalData['final_price'])) {
                        $updateData['final_price'] = $additionalData['final_price'];
                    }
                    event(new BookingCompleted($booking));
                    break;
                case 'cancelled':
                    $updateData['cancelled_at'] = now();
                    if (isset($additionalData['cancellation_reason'])) {
                        $updateData['cancellation_reason'] = $additionalData['cancellation_reason'];
                    }
                    event(new BookingCancelled($booking));
                    break;
            }

            $booking->update($updateData);

            $this->addStatusHistory(
                $booking,
                $status,
                $additionalData['note'] ?? "Status changed to {$status}",
                $user->id
            );

            return $booking->fresh(['service', 'handyman']);
        });
    }

    /**
     * Cancel a booking
     */
    public function cancelBooking(Booking $booking, User $user, string $reason): Booking
    {
        return $this->updateBookingStatus($booking, 'cancelled', $user, [
            'cancellation_reason' => $reason,
            'note' => "Booking cancelled: {$reason}",
        ]);
    }

    /**
     * Add status history entry
     */
    private function addStatusHistory(
        Booking $booking,
        string $status,
        ?string $note = null,
        ?int $changedBy = null
    ): BookingStatusHistory {
        return BookingStatusHistory::create([
            'booking_id' => $booking->id,
            'status' => $status,
            'note' => $note,
            'changed_by' => $changedBy,
        ]);
    }
}
