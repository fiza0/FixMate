<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    //Selects all users for display
    public function index() {
        $users = User::all();
        return view('admin.users.index',compact('users'));
        
    }

    //Editing for specific user
    public function edit(User $user){
        return view('admin.users.edit', compact('users'));
    }

    //Update changes to DB/storage for the specific user edited
    public function update(Request $request, User $user){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email'.$user->id,
            'phone'=>'nullable|string',
            'role'=>'required|in:homeowner,handyman,admin',
        ]);

        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success','User updated successfully.');
    }

    public function destroy(User $user){
        if($user->id === Auth::id()){
            return back()->wiht('error','You cannot delete your own account');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success','User deleted succesfully.');
    }

    public function verifyHandyman(User $user){
        if($user->role === 'handyman'){
            $user->update(['verified' => true]);
            return back()->with('succes','Handyman verified.');
        }
        return back()->with('error', 'Only handymen can be verified.');
    }

    public function unverifyHandyman(User $user){
        if($user->role === 'handyman'){
            $user->update(['verified'=>false]);
            return back()->with('success','Handyman un-verified');
        }
        return back()->with('error','This user is not a handyman.');
    }
}
