<?php
namespace App\Policies;

use App\Models\Handyman;
use App\Models\User;

class HandymanPolicy
{
    /**
     * Determine if user can view handyman profiles
     */
    public function view(User $user, Handyman $handyman): bool
    {
        return true; // Anyone can view handyman profiles
    }

    /**
     * Determine if user can update the handyman profile
     */
    public function update(User $user, Handyman $handyman): bool
    {
        return $user->id === $handyman->user_id;
    }
}