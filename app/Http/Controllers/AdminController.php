<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use App\Models\Review;

use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    public function __construct() {
        $this->middleware(['auth', 'role:admin']);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $stats = [
            'total_users' => User::count(),
            'total_handymen' => User::where('role','handyman')->count(),
            'total_bookings' => Booking::count(),
            'total_reviews' => Review::count(),
        ];
        return view('admin.dashboard', compact('user','stats'));
    }

    // Admin action example: verify handyman
    public function verifyHandyman(Request $request, User $user)
    {
        abort_unless($user->role === 'handyman', 403);
        $user->verified = true;
        $user->save();
        return back()->with('success','Handyman verified.');
    }
}
