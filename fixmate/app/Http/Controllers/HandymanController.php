<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandymanController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('handyman.dashboard', compact('user'));
    }
}
