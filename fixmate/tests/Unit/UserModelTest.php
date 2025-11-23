<?php

namespace Tests\Unit;

use App\Models\HandymanProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_role_helpers_work(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $handyman = User::factory()->create(['role' => 'handyman']);
        $homeowner = User::factory()->create(['role' => 'homeowner']);

        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($handyman->isHandyman());
        $this->assertTrue($homeowner->isHomeowner());
    }

    public function test_user_has_handyman_profile_relationship(): void
    {
        $user = User::factory()->create(['role' => 'handyman']);

        $profile = HandymanProfile::create([
            'user_id' => $user->id,
            'skill_category' => 'plumber',
            'bio' => 'Bio',
            'min_rate' => 1000,
            'max_rate' => 2000,
            'average_rating' => 0,
            'location' => 'Nairobi',
        ]);

        $this->assertTrue($user->handymanProfile->is($profile));
    }
}
