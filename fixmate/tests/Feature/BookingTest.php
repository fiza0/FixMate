<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\HandymanProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homeowner_can_create_booking(): void
    {
        $homeowner = User::factory()->create(['role' => 'homeowner']);
        $handyman  = User::factory()->create(['role' => 'handyman']);

        HandymanProfile::create([
<<<<<<< HEAD
            'user_id' => $handyman->id,
            'skill_category' => 'plumber',
            'bio' => 'Bio',
            'min_rate' => 1000,
            'max_rate' => 2000,
            'average_rating' => 0,
            'location' => 'Nairobi',
=======
            'user_id'         => $handyman->id,
            'skill_category'  => 'plumber',
            'bio'             => 'Bio',
            'min_rate'        => 1000,
            'max_rate'        => 2000,
            'average_rating'  => 0,
            'location'        => 'Nairobi',
>>>>>>> final-merge-2
        ]);

        $this->actingAs($homeowner);

        $response = $this->post(route('bookings.store'), [
<<<<<<< HEAD
            'handyman_id' => $handyman->id,
            'service_type' => 'Plumbing repair',
            'description' => 'Fix sink',
            'scheduled_at' => now()->addDay()->toDateTimeString(),
=======
            'handyman_id'    => $handyman->id,
            'service_type'   => 'Plumbing repair',
            'description'    => 'Fix sink',
            'scheduled_at'   => now()->addDay()->toDateTimeString(),
>>>>>>> final-merge-2
            'estimated_cost' => 1500,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('bookings', 1);

        $booking = Booking::first();
        $this->assertEquals('requested', $booking->status);
    }

    public function test_cannot_double_book_handyman_same_time(): void
    {
        $homeowner = User::factory()->create(['role' => 'homeowner']);
        $handyman  = User::factory()->create(['role' => 'handyman']);

        $scheduled = now()->addDays(2)->seconds(0);

        Booking::create([
<<<<<<< HEAD
            'homeowner_id' => $homeowner->id,
            'handyman_id' => $handyman->id,
            'service_type' => 'Plumbing',
            'description' => 'Existing job',
            'scheduled_at' => $scheduled,
            'status' => 'accepted',
=======
            'homeowner_id'  => $homeowner->id,
            'handyman_id'   => $handyman->id,
            'service_type'  => 'Plumbing',
            'description'   => 'Existing job',
            'scheduled_at'  => $scheduled,
            'status'        => 'accepted',
>>>>>>> final-merge-2
        ]);

        $this->actingAs($homeowner);

        $response = $this->post(route('bookings.store'), [
<<<<<<< HEAD
            'handyman_id' => $handyman->id,
            'service_type' => 'Another plumbing job',
            'description' => 'Should conflict',
=======
            'handyman_id'  => $handyman->id,
            'service_type' => 'Another plumbing job',
            'description'  => 'Should conflict',
>>>>>>> final-merge-2
            'scheduled_at' => $scheduled->toDateTimeString(),
        ]);

        $response->assertSessionHasErrors('scheduled_at');
        $this->assertEquals(1, Booking::count());
    }

<<<<<<< HEAD
    public function test_handyman_can_accept_and_complete_booking(): void
=======
    public function test_handyman_can_accept_start_and_complete_booking(): void
>>>>>>> final-merge-2
    {
        $homeowner = User::factory()->create(['role' => 'homeowner']);
        $handyman  = User::factory()->create(['role' => 'handyman']);

        $booking = Booking::create([
<<<<<<< HEAD
            'homeowner_id' => $homeowner->id,
            'handyman_id' => $handyman->id,
            'service_type' => 'Plumbing',
            'description' => 'Job',
            'scheduled_at' => now()->addDay(),
            'status' => 'requested',
=======
            'homeowner_id'  => $homeowner->id,
            'handyman_id'   => $handyman->id,
            'service_type'  => 'Plumbing',
            'description'   => 'Job',
            'scheduled_at'  => now()->addDay(),
            'status'        => 'requested',
>>>>>>> final-merge-2
        ]);

        $this->actingAs($handyman);

<<<<<<< HEAD
=======
        // accept
>>>>>>> final-merge-2
        $this->post(route('bookings.accept', $booking));
        $booking->refresh();
        $this->assertEquals('accepted', $booking->status);

<<<<<<< HEAD
=======
        // start
>>>>>>> final-merge-2
        $this->post(route('bookings.start', $booking));
        $booking->refresh();
        $this->assertEquals('in_progress', $booking->status);

<<<<<<< HEAD
=======
        // complete
>>>>>>> final-merge-2
        $this->post(route('bookings.complete', $booking));
        $booking->refresh();
        $this->assertEquals('completed', $booking->status);
    }
}
