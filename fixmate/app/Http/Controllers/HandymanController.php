<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HandymanProfile;
use App\Models\User;

class HandymanController extends Controller
{
    // Blade dashboard
    public function dashboard()
    {
        $user = Auth::user();
        return view('handyman.dashboard', compact('user'));
    }

    // Web: list (Blade page)
    public function index()
    {
        $handymen = HandymanProfile::with('user')
            ->whereHas('user', fn($q) => $q->where('verified', true))
            ->orderByDesc('average_rating')
            ->get();

        return view('handymen.index', compact('handymen'));
    }

    // Web: show
    public function show(HandymanProfile $handyman)
    {
        $handyman->load('user','user.bookingsAsHandyman','user.bookingsAsHandyman.review'); // optional
        return view('handymen.show', compact('handyman'));
    }

    // Allow handyman to update profile (web form)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        abort_unless($user->role === 'handyman', 403);

        $data = $request->validate([
            'bio' => 'nullable|string|max:2000',
            'min_rate' => 'nullable|numeric',
            'max_rate' => 'nullable|numeric',
            'location' => 'nullable|string|max:255',
            'skill_category' => 'nullable|in:plumber,electrician,carpenter,mechanic,painter,general',
        ]);

        $profile = $user->handymanProfile ?? $user->handymanProfile()->create([]);
        $profile->update($data);

        return back()->with('success','Profile updated.');
    }
}
