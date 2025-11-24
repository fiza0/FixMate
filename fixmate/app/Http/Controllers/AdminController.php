<?php

namespace App\Http\Controllers;

use App\Models\HandymanProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{


    public function dashboard()
    {
        $pendingHandymen = HandymanProfile::with('user')
            ->where('verified', false)
            ->get();

        $users = User::orderBy('created_at', 'desc')->get();

        return view('admin.dashboard', compact('pendingHandymen', 'users'));
    }

    public function verifyHandyman(HandymanProfile $handymanProfile)
{
    $handymanProfile->verified = true;
    $handymanProfile->save();
    return back()->with('success', 'Handyman verified.');
}
    public function toggleUser(User $user)
{
    $user->active = ! $user->active;
    $user->save();
    return back()->with('success', 'User status updated.');
}

    public function destroyUser(User $user)
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admins.');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function createUser()
    {
        return view('admin.create-user');
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:homeowner,handyman,admin',
            'active'   => 'boolean',
        ]);
        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'active'   => $request->has('active'),
        ]);
        return redirect()->route('admin.dashboard')->with('success', 'User added.');
    }
}
