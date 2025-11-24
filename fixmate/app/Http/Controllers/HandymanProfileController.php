<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HandymanProfile;

class HandymanProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        abort_unless($user->isHandyman(), 403);

        $profile = $user->handymanProfile;

        // Pass a blank unsaved model if not yet created
        if (!$profile) {
            $profile = new HandymanProfile([
                'skill_category' => '',
                'location' => '',
                'bio' => '',
                'min_rate' => 0,
                'max_rate' => 0,
            ]);
        }

        return view('handymen.edit-profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->isHandyman(), 403);

        $data = $request->validate([
            'skill_category' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'min_rate' => 'nullable|numeric|min:0',
            'max_rate' => 'nullable|numeric|min:0',
        ]);

        if (!$user->handymanProfile) {
            $user->handymanProfile()->create($data + [
                'verified' => false,
                'average_rating' => 0
            ]);
        } else {
            $user->handymanProfile->update($data);
        }

        return redirect()->route('handyman.profile.edit')->with('success', 'Profile updated!');
    }
}
